<h1>Здравствуйте, {{ $user->name }}!</h1>
<p>Вы успешно зарегистрированы на мероприятие: <strong>{{ $event->title }}</strong>.</p>
<p>Дата и время проведения: {{ \Carbon\Carbon::parse($event->start_time)->format('d.m.Y H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('d.m.Y H:i') }}
</p>
<p>Спасибо за вашу регистрацию!</p>
