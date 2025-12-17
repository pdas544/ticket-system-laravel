<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $agent = User::where('role', 'agent')->first();
        $user = User::where('role', 'user')->first();

        //get all categories
        $categoryIds = Category::pluck('id')->toArray();

        //create 20 sample tickets
        for($i = 1; $i <= 20; $i++){
            $ticket = Ticket::create(
                [
                    'title' => "Sample Ticket #{$i}: " . Arr::random(['Login issue', 'Slow computer', 'Printer not working', 'Email problem']),
                    'description' => "Detailed description for sample ticket #{$i}. This is a simulated issue for testing the system.",
                    'status' => Arr::random(['open', 'open', 'in_progress', 'resolved']), // Weighted towards 'open'
                    'priority' => Arr::random(['low', 'medium', 'high']),
                    'user_id' => $user->id, // Created by the regular user
                    'agent_id' => Arr::random([null, $agent->id, $admin->id]),
                ]
            );

            $ticket->categories()->attach(
                Arr::random($categoryIds, rand(1, 3))
            );
        }


    }
}
