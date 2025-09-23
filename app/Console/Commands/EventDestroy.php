<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\User;
use Illuminate\Console\Command;
use App\Mail\RegistrationCancelledAll;
use Illuminate\Support\Facades\Mail;

class EventDestroy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:cancel {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleting an event';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $eventId = $this->option('id');
        $this->info('Старт удаления события с id-' . $eventId);

        $event = Event::findOrFail($eventId);
        $participants = $event->users;
        $this->info('Количество пользователей зарегистрированных на мероприятие ' .   $participants->count());
        $users = $event->users;
        $event->users()->detach($users);


        $this->info('Отправка уведомления пользовталелям');
        foreach ($participants as $user) {
            Mail::to($user->email)->send(new RegistrationCancelledAll($user, $event));
        }

        $this->info('Мероприятие ' .  $event->title . ' удалено');
        return $event->delete();
    }
}
