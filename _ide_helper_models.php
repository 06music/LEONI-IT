<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $computer_name
 * @property string $operating_system
 * @property string $model
 * @property string|null $mac_address
 * @property string|null $ip_address
 * @property string $disk_size
 * @property string $ram
 * @property string|null $serial_number
 * @property string|null $site_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Site|null $site
 * @method static \Illuminate\Database\Eloquent\Builder|Computer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Computer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Computer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereComputerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereDiskSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereMacAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereOperatingSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereRam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Computer whereUpdatedAt($value)
 */
	class Computer extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EquipmentAssignment> $assignments
 * @property-read int|null $assignments_count
 * @property-read \App\Models\Site|null $site
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment query()
 */
	class Equipment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Equipment|null $equipment
 * @property-read \App\Models\User|null $manager
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentAssignment query()
 */
	class EquipmentAssignment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site query()
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereUpdatedAt($value)
 */
	class Site extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $username
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string $role
 * @property int|null $site_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Site|null $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_models newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_models newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_models query()
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_models whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_models whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_models whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_models whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_models whereUpdatedAt($value)
 */
	class equipment_models extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $reason_type
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_reasons newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_reasons newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_reasons query()
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_reasons whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_reasons whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_reasons whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_reasons whereReasonType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_reasons whereUpdatedAt($value)
 */
	class equipment_reasons extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_types newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_types newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_types query()
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_types whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_types whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_types whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_types whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|equipment_types whereUpdatedAt($value)
 */
	class equipment_types extends \Eloquent {}
}

