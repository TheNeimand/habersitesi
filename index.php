<?php
include 'header.php';
include 'db.php'; // Veritabanı bağlantısını dahil et

// Son 5 haberi slider için çek
$slider_haberler = $conn->query("SELECT * FROM haberler ORDER BY created_at DESC LIMIT 5");

// Kategorileri ve her kategoriden son 5 haberi çek
$kategoriler = ['Araba', 'Oyun', 'Yazılım', 'Teknoloji', 'Finans', 'Film-dizi'];
$kategori_haberleri = [];
foreach ($kategoriler as $kategori) {
    $stmt = $conn->prepare("SELECT * FROM haberler WHERE kategori = ? ORDER BY created_at DESC LIMIT 5");
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    $result = $stmt->get_result();
    $kategori_haberleri[$kategori] = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>

<main class="flex-1 bg-gray-50">
    <div class="container mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

        <!-- Slider -->
        <section class="mb-12">
            <div class="relative" x-data="{ activeSlide: 0, slides: <?php echo $slider_haberler->num_rows; ?> }">
                <!-- Slides -->
                <?php $i = 0; while ($haber = $slider_haberler->fetch_assoc()): ?>
                    <div x-show="activeSlide === <?php echo $i; ?>" class="block group">
                        <a href="<?php echo htmlspecialchars($haber['kategori']); ?>/<?php echo htmlspecialchars($haber['slug_url']); ?>">
                            <div class="relative flex min-h-[450px] w-full flex-col justify-end overflow-hidden rounded-2xl bg-cover bg-center p-8 text-white shadow-2xl transition-transform duration-300 ease-in-out group-hover:scale-105" style='background-image: linear-gradient(to top, rgba(0,0,0,0.8) 20%, rgba(0,0,0,0) 100%), url("<?php echo htmlspecialchars($haber['image_path']); ?>");'>
                                <div class="max-w-3xl">
                                    <span class="mb-2 block text-sm font-semibold uppercase tracking-widest text-white/80"><?php echo htmlspecialchars($haber['kategori']); ?></span>
                                    <h2 class="text-4xl font-bold leading-tight tracking-tight text-white md:text-5xl font-serif">
                                        <?php echo htmlspecialchars($haber['title']); ?>
                                    </h2>
                                    <p class="mt-4 text-lg text-white/90 hidden sm:block">
                                        <?php echo htmlspecialchars($haber['description']); ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php $i++; endwhile; ?>

                <!-- Controls -->
                <div class="absolute inset-0 flex items-center justify-between p-4">
                    <button @click="activeSlide = (activeSlide - 1 + slides) % slides" class="bg-black bg-opacity-50 text-white rounded-full p-2">
                        &#10094;
                    </button>
                    <button @click="activeSlide = (activeSlide + 1) % slides" class="bg-black bg-opacity-50 text-white rounded-full p-2">
                        &#10095;
                    </button>
                </div>
            </div>
        </section>

        <!-- Kategori Haberleri -->
        <?php foreach ($kategoriler as $kategori): ?>
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 pb-2 border-b-2 border-gray-200 font-serif"><?php echo $kategori; ?></h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                    <?php foreach ($kategori_haberleri[$kategori] as $haber): ?>
                        <article class="group">
                            <a href="<?php echo htmlspecialchars($haber['kategori']); ?>/<?php echo htmlspecialchars($haber['slug_url']); ?>" class="block">
                                <img src="<?php echo htmlspecialchars($haber['image_path']); ?>" alt="<?php echo htmlspecialchars($haber['title']); ?>" class="w-full h-56 object-cover rounded-xl shadow-md transition-transform duration-300 group-hover:scale-105">
                                <div class="mt-4">
                                    <h3 class="mt-2 text-xl font-bold text-gray-800 group-hover:text-indigo-700 transition-colors"><?php echo htmlspecialchars($haber['title']); ?></h3>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>

    </div>
</main>

<?php include 'footer.php'; ?>
