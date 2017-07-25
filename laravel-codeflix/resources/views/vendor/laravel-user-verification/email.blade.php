<h3>{{config('app.name')}}</h3>
<p>Sua conta na Plataforma CodeFlix foi criada</p>
<p>Clique
    <a href="{{ $link = route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}">
        Aqui
    </a>
    para verificar sua conta
</p>
<p>Obs: Não responda este email, ele é gerado automaticamente</p>

