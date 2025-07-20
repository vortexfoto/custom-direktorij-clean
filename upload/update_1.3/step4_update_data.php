use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// Table Create 
if (!Schema::hasTable('custom_fields')) {
    Schema::create('custom_fields', function (Blueprint $table) {
        $table->id();
        $table->integer('listing_id')->nullable();
        $table->string('listing_type', 255)->nullable();
        $table->string('custom_type', 255)->nullable();
        $table->string('custom_title', 255)->nullable();
        $table->longText('custom_field')->nullable();
        $table->integer('sorting')->nullable();
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
        
    });
}


// Table Create 
if (!Schema::hasTable('custom_listings')) {
    Schema::create('custom_listings', function (Blueprint $table) {
        $table->id();
        $table->string('type', 255)->nullable();
        $table->integer('type_id')->nullable();
        $table->string('title', 255)->nullable();
        $table->longText('description')->nullable();
        $table->string('visibility', 255)->nullable();
        $table->string('meta_title', 255)->nullable();
        $table->string('meta_keyword', 255)->nullable();
        $table->string('meta_description', 255)->nullable();
        $table->string('og_title', 255)->nullable();
        $table->string('og_description', 255)->nullable();
        $table->string('og_image', 255)->nullable();
        $table->string('canonical_url', 255)->nullable();
        $table->longText('json_id', 255)->nullable();
        $table->string('country', 255)->nullable();
        $table->string('city', 255)->nullable();
        $table->string('area', 255)->nullable();
        $table->string('address', 255)->nullable();
        $table->string('postal_code', 255)->nullable();
        $table->string('Latitude', 255)->nullable();
        $table->string('Longitude', 255)->nullable();
        $table->string('image', 255)->nullable();
        $table->string('category', 255)->nullable();
        $table->string('feature', 255)->nullable();
        $table->integer('user_id')->nullable();
        $table->integer('is_claimed')->nullable();
        $table->string('is_popular', 255)->nullable();
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
        
    });
}

if (!Schema::hasColumn('amenities', 'type_id')) {
    Schema::table('amenities', function (Blueprint $table) {
        $table->integer('type_id')->nullable();
    });
}
if (!Schema::hasColumn('categories', 'type_id')) {
    Schema::table('categories', function (Blueprint $table) {
        $table->integer('type_id')->nullable();
    });
}