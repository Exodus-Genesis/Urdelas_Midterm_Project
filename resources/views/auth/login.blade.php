<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameCollection - Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900 min-h-screen flex">

    <!-- Left Side: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-800 rounded-lg mb-4">
                    <span class="text-4xl">🕹️</span>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2">Gamecollection</h1>
                <p class="text-gray-300">Manage Your Game Collection</p>
            </div>

            <!-- Login Card -->
            <div class="bg-gray-800 rounded-lg shadow-2xl overflow-hidden">
                <div class="bg-gray-700 px-6 py-8">
                    <h2 class="text-2xl font-bold text-white">Greetings!</h2>
                    <p class="text-gray-300 text-sm mt-1">Enter your credentials to continue</p>
                </div>

                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                            <input type="email" name="email" placeholder="Enter your email"
                                class="w-full px-4 py-3 border-2 border-gray-600 rounded-lg bg-gray-900 text-white focus:border-gray-400 focus:ring-2 focus:ring-gray-500 outline-none transition text-sm" required />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                            <input type="password" name="password" placeholder="Enter your password"
                                class="w-full px-4 py-3 border-2 border-gray-600 rounded-lg bg-gray-900 text-white focus:border-gray-400 focus:ring-2 focus:ring-gray-500 outline-none transition text-sm" required />
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember"
                                class="w-4 h-4 text-gray-300 border-gray-600 rounded focus:ring-2 focus:ring-gray-400" />
                            <label for="remember" class="ml-2 text-sm text-gray-300">Remember me</label>
                        </div>

                        <button type="submit"
                            class="w-full py-3 bg-gray-700 text-white font-semibold rounded-lg hover:bg-gray-600 transition-all duration-200 flex items-center justify-center gap-2">
                            <span>🔑</span> <span>Login</span>
                        </button>
                    </form>

                    <!-- Demo Info -->
                    <div class="mt-6 bg-gray-700 border border-gray-600 rounded-lg p-4 text-xs text-gray-300">
                        <p><span class="font-semibold">Email:</span> demo@example.com</p>
                        <p><span class="font-semibold">Password:</span> password123</p>
                        <p class="mt-2 italic text-gray-400">💡 This is a dummy login page. Any credentials work!</p>
                    </div>
                </div>

                <div class="bg-gray-900 px-6 py-4 border-t border-gray-700 text-center text-xs text-gray-400">
                    🕹️ GameCollection © 2025
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Graphic -->
    <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-blue-700 to-purple-700 items-center justify-center">
        <!-- Replace with an image or illustration -->
        <img src="https://cdn-icons-png.flaticon.com/512/3063/3063822.png" alt="Gaming Graphic" class="w-3/4 h-auto"/>
    </div>

</body>
</html>
