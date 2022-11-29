<?php

namespace App;

use App\Building;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ActivityLogTrait;
// use Spatie\Activitylog\Traits\LogsActivity;

class Building extends Model
{
    use ActivityLogTrait;
    const AVAILABLE = 1;
    const COMING_SOON = 0;

    protected $guarded = [];
    // protected static $logAttributes = ['name', 'floor', 'location', 'description', 'waze_link', 'google_map_link', 'latitude', 'longitude', 'availability'];

    public function images()
    {
    	return $this->hasOne(BuildingImage::class);
    }

    public function rooms()
    {
    	return $this->hasMany(Room::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function amenity()
    {
        return $this->hasMany(Amenity::class);
    }

    public function reservation()
    {
        return $this->hasOne(Reservation::class);
    }   

    public function banners()
    {
        return $this->hasMany(BuildingBanner::class);
    }

    public static function getPositionByAddress($location) {
        $lat = null;
        $lng = null;

        $string = str_replace (" ", "+", urlencode($location));
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?';
        $url .= "address={$string}";
        $url .= '&components=country:PH';
        $url .= '&sensor=true';
        $url .= '&key=' . config('custom.gmap.key');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);

        if ($response['status'] == 'OK') {
            $lat = $response['results'][0]['geometry']['location']['lat'];
            $lng = $response['results'][0]['geometry']['location']['lng'];
            $message = 'You have successfully fetch the address position.';
        } else {
            $message = $response['status'];
        }

        return [
            'latitude' => $lat,
            'longitude' => $lng,
            'message' => $message,
        ];
    }

    public function redirectTo() 
    {
        return route('building.create');
    }

    public function renderBack()
    {
        return route('building.edit', $this->id);
    }

    /**
     * filter available buildings
     * @param  $query 
     * @return response
     */
    public function scopeAvailable($query)
    {
        $query->where('availability', Building::AVAILABLE);
    }

    /**
     * filter coming soon buildings
     * @param  $query 
     * @return response
     */
    public function scopeComingSoon($query)
    {
        return $query->where('availability', Building::COMING_SOON);
    }

    /**
     * Get route by building name
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Return coming soon class if not available
     * @return boolean/string
     */
    public function isAvailableReturnCSSClass()
    {
        if($this->availability == Building::AVAILABLE)
            return true;

        return 'coming_soon';
    }

    public function renderName() {
        return $this->name;
    }

    public function renderImage()
    {
        return '/storage/' . $this->images;
    }
}
