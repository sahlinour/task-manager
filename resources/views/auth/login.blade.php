<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Task Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 min-h-screen flex items-center justify-center">

  <!-- Glass Card -->
  <div class="bg-gray-900/60 backdrop-blur-md rounded-3xl shadow-2xl p-10 w-full max-w-md animate-fadeIn">
    <h2 class="text-4xl font-bold text-white text-center mb-6">Connexion</h2>

    <form action="{{ route('login') }}" method="POST" class="space-y-6">
         @csrf
      
      <div class="relative">
        <input type="email" name="email" placeholder="Email" 
               class="peer w-full px-4 py-3 rounded-xl bg-gray-800/70 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"/>
       </div>

      <!-- Password -->
      <div class="relative">
        <input type="password" name="password" placeholder="Mot de passe" 
               class="peer w-full px-4 py-3 rounded-xl bg-gray-800/70 text-white border border-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"/>
          </div>

      <!-- Submit Button -->
      <button type="submit" 
              class="w-full py-3 hover:bg-[#CF0F47] rounded-xl text-white font-semibold bg-[#FF0B55] transition duration-300 transform hover:scale-105">
        Se connecter
      </button>
    </form>

    <p class="mt-6 text-center text-gray-400">
      Pas encore de compte? 
      <a href="{{ route('register') }}" class="text-[#FF0B55] hover:underline">Inscrivez-vous</a>
    </p>
  </div>

  <!-- Animations CSS -->
  <style>
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
      animation: fadeIn 0.8s ease forwards;
    }
  </style>
</body>
</html>