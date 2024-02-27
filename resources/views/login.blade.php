<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full p-6 bg-white shadow-md">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Connexion</h2>

            @if(session('success'))
                <p class="text-green-500">{{ session('success') }}</p>
            @endif

            @if($errors->any())
                <ul class="text-red-500">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <script>
                // Récupérer le message flash
                var successMessage = "{{ session('success') }}";
                if (successMessage) {
                    alert(successMessage);
                }
            
                // Récupérer le token de la session et le stocker dans le localStorage
                var token = "{{ session('token') }}";
                if (token) {
                    localStorage.setItem("token", token);
                }
            </script>
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">E-mail</label>
                    <input type="email" name="email" id="email" class="mt-1 p-2 w-full border rounded-md" value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600">Mot de passe</label>
                    <input type="password" name="password" id="password" class="mt-1 p-2 w-full border rounded-md" required>
                </div>

                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label for="remember" class="text-sm text-gray-600">Se souvenir de moi</label>
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">Se connecter</button>
                </div>
            </form>

            <p>Vous n'avez pas de compte? <a href="{{ route('register') }}" class="text-blue-500">S'inscrire ici</a></p>
        </div>
    </div>
</body>
</html>
