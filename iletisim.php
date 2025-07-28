<?php include 'header.php'; ?>

<main class="flex-grow py-12 sm:py-20 bg-gray-50">
<div class="mx-auto max-w-4xl px-6 lg:px-8">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl font-serif">İletişim</h1>
        <p class="mt-4 text-lg leading-8 text-gray-600">Bize ulaşın. Sorularınızı, geri bildirimlerinizi ve haber ipuçlarınızı duymaktan memnuniyet duyarız.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
        <!-- İletişim Bilgileri -->
        <div class="space-y-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Adres Bilgileri</h2>
                <p class="mt-2 text-gray-700">123 Haber Sokağı, Başyazı Şehri, 34000, Türkiye</p>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">E-posta</h2>
                <p class="mt-2 text-gray-700"><a href="mailto:info@newstoday.com" class="text-indigo-600 hover:underline">info@newstoday.com</a></p>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Telefon</h2>
                <p class="mt-2 text-gray-700"><a href="tel:+902121234567" class="text-indigo-600 hover:underline">+90 (212) 123 45 67</a></p>
            </div>
        </div>

        <!-- İletişim Formu -->
        <div>
            <form action="#" method="POST">
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Adınız Soyadınız</label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" autocomplete="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">E-posta Adresiniz</label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" autocomplete="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Mesajınız</label>
                        <div class="mt-1">
                            <textarea id="message" name="message" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Gönder
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</main>

<?php include 'footer.php'; ?>