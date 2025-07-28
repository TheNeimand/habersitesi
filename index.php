<?php include 'header.php'; ?>

<main class="flex-1 bg-gray-50">
    <div class="container mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

        <!-- Sayfa Başlığı -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 sm:text-6xl font-serif">NewsToday</h1>
            <p class="mt-4 text-xl text-gray-600">Türkiye ve dünyadan en güncel haberler.</p>
        </div>

        <div class="grid grid-cols-12 gap-8">

            <!-- Ana Haber Akışı (Sol Sütun) -->
            <div class="col-span-12 lg:col-span-8 space-y-16">

                <!-- Manşet Haberi -->
                <section>
                    <a href="haber-detay.php" class="block group">
                        <div class="relative flex min-h-[450px] w-full flex-col justify-end overflow-hidden rounded-2xl bg-cover bg-center p-8 text-white shadow-2xl transition-transform duration-300 ease-in-out group-hover:scale-105" style='background-image: linear-gradient(to top, rgba(0,0,0,0.8) 20%, rgba(0,0,0,0) 100%), url("https://images.unsplash.com/photo-1579532537598-459ecdaf39cc?q=80&w=2070&auto=format&fit=crop");'>
                            <div class="max-w-3xl">
                                <span class="mb-2 block text-sm font-semibold uppercase tracking-widest text-white/80">Manşet</span>
                                <h2 class="text-4xl font-bold leading-tight tracking-tight text-white md:text-5xl font-serif">
                                    Küresel Liderler İklim Değişikliği Zirvesi'nde Buluştu: Kritik Kararlar Alındı
                                </h2>
                                <p class="mt-4 text-lg text-white/90 hidden sm:block">
                                    Dünya liderleri, artan iklim kriziyle mücadele etmek için acil eylem planlarını tartışmak üzere bir araya geldi. Zirveden, karbon emisyonlarını azaltma ve yeşil enerjiye geçişi hızlandırma yönünde tarihi taahhütler çıktı.
                                </p>
                            </div>
                        </div>
                    </a>
                </section>

                <!-- Son Haberler -->
                <section>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-gray-200 font-serif">Son Haberler</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        
                        <article class="group">
                            <a href="haber-detay.php" class="block">
                                <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=2070&auto=format&fit=crop" alt="Teknoloji haberi" class="w-full h-56 object-cover rounded-xl shadow-md transition-transform duration-300 group-hover:scale-105">
                                <div class="mt-4">
                                    <span class="text-sm font-semibold text-indigo-600">Teknoloji</span>
                                    <h3 class="mt-2 text-xl font-bold text-gray-800 group-hover:text-indigo-700 transition-colors">Yapay Zeka, Sağlık Sektöründe Devrim Yaratıyor</h3>
                                    <p class="mt-2 text-gray-600 text-sm">Yeni bir araştırma, yapay zekanın hastalık teşhisinde doktorlardan daha isabetli sonuçlar verebildiğini ortaya koydu.</p>
                                </div>
                            </a>
                        </article>

                        <article class="group">
                            <a href="haber-detay.php" class="block">
                                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop" alt="Ekonomi haberi" class="w-full h-56 object-cover rounded-xl shadow-md transition-transform duration-300 group-hover:scale-105">
                                <div class="mt-4">
                                    <span class="text-sm font-semibold text-green-600">Ekonomi</span>
                                    <h3 class="mt-2 text-xl font-bold text-gray-800 group-hover:text-green-700 transition-colors">Merkez Bankası'ndan Sürpriz Faiz Kararı</h3>
                                    <p class="mt-2 text-gray-600 text-sm">Piyasaların beklemediği bir hamleyle, Merkez Bankası politika faizini 50 baz puan artırdığını duyurdu.</p>
                                </div>
                            </a>
                        </article>

                        <article class="group">
                            <a href="haber-detay.php" class="block">
                                <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=2070&auto=format&fit=crop" alt="Spor haberi" class="w-full h-56 object-cover rounded-xl shadow-md transition-transform duration-300 group-hover:scale-105">
                                <div class="mt-4">
                                    <span class="text-sm font-semibold text-red-600">Spor</span>
                                    <h3 class="mt-2 text-xl font-bold text-gray-800 group-hover:text-red-700 transition-colors">Milli Takım, Avrupa Şampiyonası'na Galibiyetle Başladı</h3>
                                    <p class="mt-2 text-gray-600 text-sm">Ay-yıldızlılar, turnuvanın açılış maçında güçlü rakibini 2-1 mağlup ederek turnuvaya iddialı bir başlangıç yaptı.</p>
                                </div>
                            </a>
                        </article>

                        <article class="group">
                            <a href="haber-detay.php" class="block">
                                <img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=2072&auto=format&fit=crop" alt="Siyaset haberi" class="w-full h-56 object-cover rounded-xl shadow-md transition-transform duration-300 group-hover:scale-105">
                                <div class="mt-4">
                                    <span class="text-sm font-semibold text-blue-600">Siyaset</span>
                                    <h3 class="mt-2 text-xl font-bold text-gray-800 group-hover:text-blue-700 transition-colors">Yeni Anayasa Tartışmaları Meclis Gündeminde</h3>
                                    <p class="mt-2 text-gray-600 text-sm">Partiler, anayasa değişiklik teklifleri üzerinde uzlaşma arayışı için komisyon kurma kararı aldı.</p>
                                </div>
                            </a>
                        </article>

                    </div>
                </section>

            </div>

            <!-- Kenar Çubuğu (Sağ Sütun) -->
            <aside class="col-span-12 lg:col-span-4 space-y-8">
                
                <!-- Popüler Haberler -->
                <div class="p-6 bg-white rounded-xl shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 font-serif">Popüler Haberler</h3>
                    <ul class="mt-4 space-y-4">
                        <li class="flex items-start gap-4">
                            <span class="text-2xl font-bold text-gray-300">1</span>
                            <a href="haber-detay.php" class="text-gray-800 hover:text-indigo-600 font-semibold">Geleceğin telefonları: Katlanabilir ekranlar yaygınlaşıyor.</a>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="text-2xl font-bold text-gray-300">2</span>
                            <a href="haber-detay.php" class="text-gray-800 hover:text-indigo-600 font-semibold">Uzay turizmi için bilet satışları rekor seviyede.</a>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="text-2xl font-bold text-gray-300">3</span>
                            <a href="haber-detay.php" class="text-gray-800 hover:text-indigo-600 font-semibold">İstanbul'da trafik sorununa metro çözümü.</a>
                        </li>
                         <li class="flex items-start gap-4">
                            <span class="text-2xl font-bold text-gray-300">4</span>
                            <a href="haber-detay.php" class="text-gray-800 hover:text-indigo-600 font-semibold">Ünlü yazarın yeni kitabı satış rekorları kırıyor.</a>
                        </li>
                    </ul>
                </div>

                <!-- Kategoriler -->
                <div class="p-6 bg-white rounded-xl shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 font-serif">Kategoriler</h3>
                    <ul class="mt-4 space-y-2">
                        <li><a href="katagori.php" class="block p-2 rounded-md text-gray-700 hover:bg-gray-100 hover:text-indigo-600 font-medium">Teknoloji</a></li>
                        <li><a href="katagori.php" class="block p-2 rounded-md text-gray-700 hover:bg-gray-100 hover:text-indigo-600 font-medium">Ekonomi</a></li>
                        <li><a href="katagori.php" class="block p-2 rounded-md text-gray-700 hover:bg-gray-100 hover:text-indigo-600 font-medium">Spor</a></li>
                        <li><a href="katagori.php" class="block p-2 rounded-md text-gray-700 hover:bg-gray-100 hover:text-indigo-600 font-medium">Siyaset</a></li>
                        <li><a href="katagori.php" class="block p-2 rounded-md text-gray-700 hover:bg-gray-100 hover:text-indigo-600 font-medium">Sağlık</a></li>
                        <li><a href="katagori.php" class="block p-2 rounded-md text-gray-700 hover:bg-gray-100 hover:text-indigo-600 font-medium">Bilim</a></li>
                    </ul>
                </div>

            </aside>

        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
