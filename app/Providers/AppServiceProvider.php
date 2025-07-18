namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Item;
use App\Models\Message;
use App\Policies\ItemPolicy;
use App\Policies\MessagePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Item::class => ItemPolicy::class,
        Message::class => MessagePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
