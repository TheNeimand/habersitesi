<?php
include 'header.php';
include 'db.php';

// Kategori adını al
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Sayfalama için ayarlar
$limit = 12; // Sayfa başına haber sayısı
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

// Toplam haber sayısını al
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM haberler WHERE kategori = ?");
$stmt->bind_param("s", $kategori);
$stmt->execute();
$result = $stmt->get_result();
$total = $result->fetch_assoc()['total'];
$pages = ceil($total / $limit);

// Haberleri çek
$stmt = $conn->prepare("SELECT * FROM haberler WHERE kategori = ? ORDER BY created_at DESC LIMIT ?, ?");
$stmt->bind_param("sii", $kategori, $start, $limit);
$stmt->execute();
$haberler = $stmt->get_result();
?>

<main class="w-full flex-1">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mb-10">
            <a class="inline-flex items-center gap-2 text-sm font-medium text-[var(--text-secondary)] hover:text-[var(--primary-color)] transition-colors" href="index.php">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="m15 18-6-6 6-6"></path>
                </svg>
                Ana Sayfaya Dön
            </a>
            <div class="mt-4">
                <h2 class="text-4xl font-extrabold tracking-tight text-[var(--primary-color)] sm:text-5xl"><?php echo htmlspecialchars($kategori); ?></h2>
                <p class="mt-2 max-w-2xl text-lg text-[var(--text-secondary)]"><?php echo htmlspecialchars($kategori); ?> dünyasından en son haberler ve gelişmeler.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-x-8 gap-y-12 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <?php while ($haber = $haberler->fetch_assoc()): ?>
                <article class="flex flex-col items-start justify-between">
                    <a class="group" href="<?php echo htmlspecialchars($haber['kategori']); ?>/<?php echo htmlspecialchars($haber['slug_url']); ?>">
                        <div class="relative w-full">
                            <img alt="<?php echo htmlspecialchars($haber['title']); ?>" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover transition-transform duration-300 group-hover:scale-105" src="<?php echo htmlspecialchars($haber['image_path']); ?>"/>
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                        </div>
                        <div class="max-w-xl">
                            <div class="mt-6 flex items-center gap-x-4 text-xs">
                                <time class="text-gray-500" datetime="<?php echo date('Y-m-d', strtotime($haber['created_at'])); ?>"><?php echo date('d M Y', strtotime($haber['created_at'])); ?></time>
                            </div>
                            <div class="relative mt-3">
                                <h3 class="text-xl font-bold leading-7 text-gray-900 group-hover:text-indigo-700 transition-colors">
                                    <?php echo htmlspecialchars($haber['title']); ?>
                                </h3>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
        <!-- Sayfalama -->
        <div class="mt-12 flex justify-center">
            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <a href="<?php echo htmlspecialchars($kategori); ?>?page=<?php echo $i; ?>" class="<?php echo $page === $i ? 'bg-indigo-600 text-white' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50'; ?> relative inline-flex items-center px-4 py-2 text-sm font-semibold focus:z-20">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </nav>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>