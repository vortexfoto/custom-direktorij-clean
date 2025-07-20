<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddCustomWebsiteUrl extends Command
{
    protected $signature = 'add:custom-website-url';
    protected $description = 'Doda polje "Povezava do spletne strani" vsem listingom v tabeli custom_fields';

    public function handle()
    {
        $types = [
            'beauty',
            'car',
            'restaurant',
            'hotel',
            'real_estate',
            'custom',
            'spletne-strani',
        ];

        $dodano = 0;

        foreach ($types as $listingType) {
            $obstaja = DB::table('custom_fields')
                ->where('listing_type', $listingType)
                ->where('custom_title', 'Povezava do spletne strani')
                ->exists();

            if (!$obstaja) {
                DB::table('custom_fields')->insert([
                    'listing_type' => $listingType,
                    'custom_type' => 'text',
                    'custom_title' => 'Povezava do spletne strani',
                    'custom_field' => null,
                    'sorting' => 99,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->info("✅ Dodano za: $listingType");
                $dodano++;
            } else {
                $this->line("ℹ️  Obstaja že za: $listingType");
            }
        }

        $this->info("✅ Zaključeno. Skupaj dodano: $dodano polj.");
        return 0;
    }
}
