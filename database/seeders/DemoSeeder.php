<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\LastWatching;
use App\Models\Like;
use App\Models\Manga;
use App\Models\Profile;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TagSeeder::class);

        Model::unguarded(function () {
            $users  = $this->seedUsers();
            $mangas = $this->seedMangas();

            $this->seedChapters($mangas, $users->first());
            $this->seedUserActivity($users, $mangas);
        });
    }

    private function seedUsers()
    {
        $accounts = [
            ['alimdaghmesh@gmail.com', 'admin', 'Admin User'],
            ['alimdaghmesh116@gmail.com', 'moderator', 'Moderator User'],
        ];

        foreach (range(1, 5) as $i) {
            $accounts[] = ["user{$i}@gmail.com", 'user', fake()->name()];
        }

        $users = collect();

        foreach ($accounts as [$email, $role, $fullName]) {
            $user = User::create([
                'email'             => $email,
                'role'              => $role,
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            Profile::create([
                'user_id'   => $user->id,
                'full_name' => $fullName,
                'birthdate' => fake()->date('Y-m-d', '2005-01-01'),
            ]);

            $users->push($user);
        }

        return $users;
    }

    private function seedMangas()
    {
        $items = [
            ['local', 'Blade of the Silent Moon'],
            ['local', 'Ashes of the Last Kingdom'],
            ['local', 'Cafe at the End of the World'],
            ['mangadex', 'Starlight Delivery Service'],
            ['mangadex', 'The Clockwork Detective'],
        ];

        $tagIds = Tag::pluck('id');

        return collect($items)->map(function ($item) use ($tagIds) {
            [$source, $title] = $item;

            $manga = Manga::create([
                'source'      => $source,
                'mangadex_id' => $source === 'mangadex' ? (string) Str::uuid() : null,
                'title'       => $title,
                'description' => fake()->paragraph(),
                'author_name' => fake()->name(),
                'artist_name' => fake()->name(),
            ]);

            $manga->tags()->attach($tagIds->random(3));

            return $manga;
        });
    }

    private function seedChapters($mangas, User $admin): void
    {
        foreach ($mangas as $manga) {
            $isLocal = $manga->source === 'local';

            foreach (range(1, 5) as $number) {
                Chapter::create([
                    'manga_id'       => $manga->id,
                    'source'         => $isLocal ? 'local' : 'mangaDex',
                    'chapter_number' => $number,
                    'title'          => "Chapter {$number}",
                    'uploaded_by'    => $isLocal ? $admin->id : null,
                ]);
            }
        }
    }

    private function seedUserActivity($users, $mangas): void
    {
        $chapters = Chapter::all();

        foreach ($users as $user) {
            foreach ($mangas->random(3) as $manga) {
                Favorite::create(['user_id' => $user->id, 'manga_id' => $manga->id]);
            }

            foreach ($mangas->random(2) as $manga) {
                Like::create(['user_id' => $user->id, 'manga_id' => $manga->id]);
            }

            foreach ($chapters->random(3) as $chapter) {
                Comment::create([
                    'user_id'    => $user->id,
                    'chapter_id' => $chapter->id,
                    'content'    => fake()->sentence(),
                ]);
            }

            $manga = $mangas->random();

            LastWatching::create([
                'user_id'        => $user->id,
                'manga_id'       => $manga->id,
                'chapter_id'     => $chapters->where('manga_id', $manga->id)->random()->id,
                'last_page_read' => fake()->numberBetween(1, 20),
            ]);
        }
    }
}