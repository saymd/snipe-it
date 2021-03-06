<?php

class License extends Depreciable
{
	use SoftDeletingTrait;
    protected $dates = ['deleted_at'];

    public $timestamps = true;

    protected $guarded = 'id';
    protected $table = 'licenses';
    protected $rules = array(
            'name'   => 'required|alpha_space|min:3|max:255',
            'serial'   => 'required|min:5',
            'seats'   => 'required|min:1|max:10000|integer',
            'license_email'   => 'email|min:0|max:120',
            'license_name'   => 'alpha_space|min:0|max:100',
            'note'   => 'alpha_space',
            'notes'   => 'alpha_space|min:0',
        );

    /**
     * Get the assigned user
     */
    public function assignedusers()
    {
        return $this->belongsToMany('User','license_seats','assigned_to','license_id');
    }

    /**
    * Get asset logs for this asset
    */
    public function assetlog()
    {
        return $this->hasMany('Actionlog','asset_id')
            ->where('asset_type', '=', 'software')
            ->orderBy('created_at', 'desc');
    }

    /**
    * Get uploads for this asset
    */
    public function uploads()
    {
        return $this->hasMany('Actionlog','asset_id')
            ->where('asset_type', '=', 'software')
            ->where('action_type', '=', 'uploaded')
            ->whereNotNull('filename')
            ->orderBy('created_at', 'desc');
    }


    /**
    * Get admin user for this asset
    */
    public function adminuser()
    {
        return $this->belongsTo('User','user_id');
    }

    /**
    * Get total licenses
    */
     public static function assetcount()
    {
        return DB::table('license_seats')
                    ->whereNull('deleted_at')
                    ->count();
    }


    /**
    * Get total licenses
    */
     public function totalSeatsByLicenseID()
    {
        return DB::table('license_seats')
        			->where('license_id', '=', $this->id)
                    ->whereNull('deleted_at')
                    ->count();
    }


    /**
    * Get total licenses not checked out
    */
     public static function availassetcount()
    {
        return DB::table('license_seats')
                    ->whereNull('assigned_to')
                    ->whereNull('asset_id')
                    ->whereNull('deleted_at')
                    ->count();
    }

    /**
     * Get the number of available seats
     */
    public function availcount()
    {
        return DB::table('license_seats')
                    ->whereNull('assigned_to')
                    ->whereNull('asset_id')
                    ->where('license_id', '=', $this->id)
                    ->whereNull('deleted_at')
                    ->count();
    }

    /**
     * Get the number of assigned seats
     *
     */
    public function assignedcount()
    {

		return LicenseSeat::where('license_id', '=', $this->id)
			->where( function ( $query )
			{
			$query->whereNotNull('assigned_to')
			->orWhereNotNull('asset_id');
			})
		->count();


    }

    public function remaincount()
    {
    	$total = $this->totalSeatsByLicenseID();
        $taken =  $this->assignedcount();
        $diff =   ($total - $taken);
        return $diff;
    }

    /**
     * Get the total number of seats
     */
    public function totalcount()
    {
        $avail =  $this->availcount();
        $taken =  $this->assignedcount();
        $diff =   ($avail + $taken);
        return $diff;
    }

    /**
     * Get license seat data
     */
    public function licenseseats()
    {
        return $this->hasMany('LicenseSeat');
    }

    public function supplier()
    {
        return $this->belongsTo('Supplier','supplier_id');
    }

public function freeSeat()
    {
        $seat = LicenseSeat::where('license_id','=',$this->id)
                    ->whereNull('deleted_at')
                    ->whereNull('assigned_to')
                    ->whereNull('asset_id')
                    ->first();
        return $seat->id;
    }

	public static function getExpiringLicenses($days = 60) {

	    return License::whereNotNull('expiration_date')
		->whereNull('deleted_at')
		->whereRaw(DB::raw( 'DATE_SUB(`expiration_date`,INTERVAL '.$days.' DAY) <= DATE(NOW()) ' ))
		->where('expiration_date','>',date("Y-m-d"))
		->orderBy('expiration_date', 'ASC')
		->get();

    }
}
