<?php include 'header.php'; ?>
<main class="w-full flex-1">
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
<div class="mb-10">
<a class="inline-flex items-center gap-2 text-sm font-medium text-[var(--text-secondary)] hover:text-[var(--primary-color)] transition-colors" href="index.php">
<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="m15 18-6-6 6-6"></path>
</svg>
Ana Sayfaya Dön
</a>
<div class="mt-4 flex items-center justify-between">
<div>
<h2 class="text-4xl font-extrabold tracking-tight text-[var(--primary-color)] sm:text-5xl">Teknoloji</h2>
<p class="mt-2 max-w-2xl text-lg text-[var(--text-secondary)]">Teknoloji dünyasından en son haberler ve gelişmeler.</p>
</div>
<div class="flex items-center gap-2">
<span class="text-sm font-medium text-gray-500">Sırala:</span>
<select class="rounded-md border-gray-300 py-2 pl-3 pr-9 text-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
<option>En Yeni</option>
<option>En Popüler</option>
</select>
</div>
</div>
</div>
<div class="grid grid-cols-1 gap-x-8 gap-y-12 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
<article class="flex flex-col items-start justify-between">
<a class="group" href="haber-detay.php">
<div class="relative w-full">
<img alt="Yapay zeka haberleri" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover transition-transform duration-300 group-hover:scale-105" src="https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=2070&auto=format&fit=crop"/>
<div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
</div>
<div class="max-w-xl">
<div class="mt-6 flex items-center gap-x-4 text-xs">
<time class="text-gray-500" datetime="2024-05-18">18 Mayıs 2024</time>
<span class="relative z-10 rounded-full bg-indigo-100 px-3 py-1.5 font-medium text-indigo-700">Yapay Zeka</span>
</div>
<div class="relative mt-3">
<h3 class="text-xl font-bold leading-7 text-gray-900 group-hover:text-indigo-700 transition-colors">
Yapay Zeka Geliştiricileri İçin Yeni Araçlar Tanıtıldı
</h3>
<p class="mt-2 line-clamp-3 text-sm leading-6 text-gray-600">Önde gelen teknoloji şirketleri, yapay zeka geliştirme süreçlerini kolaylaştıracak yeni platformlarını ve kütüphanelerini duyurdu.</p>
</div>
</div>
</a>
</article>
<article class="flex flex-col items-start justify-between">
<a class="group" href="haber-detay.php">
<div class="relative w-full">
<img alt="Siber güvenlik haberleri" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover transition-transform duration-300 group-hover:scale-105" src="https://images.unsplash.com/photo-1550751827-4138d04d475d?q=80&w=2072&auto=format&fit=crop"/>
<div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
</div>
<div class="max-w-xl">
<div class="mt-6 flex items-center gap-x-4 text-xs">
<time class="text-gray-500" datetime="2024-05-17">17 Mayıs 2024</time>
<span class="relative z-10 rounded-full bg-red-100 px-3 py-1.5 font-medium text-red-700">Siber Güvenlik</span>
</div>
<div class="relative mt-3">
<h3 class="text-xl font-bold leading-7 text-gray-900 group-hover:text-red-700 transition-colors">
Yeni Siber Saldırı Dalgası Şirketleri Tehdit Ediyor
</h3>
<p class="mt-2 line-clamp-3 text-sm leading-6 text-gray-600">Uzmanlar, dünya genelinde birçok şirketi hedef alan yeni ve karmaşık bir siber saldırı türüne karşı uyarıda bulundu.</p>
</div>
</div>
</a>
</article>
<!-- Diğer haber kartları buraya eklenebilir -->
</div>
</div>
</main>
<?php include 'footer.php'; ?>