use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



//Table structure for table `form_builders`
if(!Schema::hasTable('form_builders'))
{
    Schema::create('form_builders', function (Blueprint $table) {
        $table->id();
        $table->integer('user_id')->nullable();
        $table->string('type', 255)->nullable();
        $table->longtext('form_builder')->nullable();
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
    });
}


