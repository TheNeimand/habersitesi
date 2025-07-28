<?php
include 'header.php';
include 'db.php';

// Slug ve kategori bilgilerini al
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Haberi çek
$stmt = $conn->prepare("SELECT * FROM haberler WHERE slug_url = ? AND kategori = ?");
$stmt->bind_param("ss", $slug, $kategori);
$stmt->execute();
$result = $stmt->get_result();
$haber = $result->fetch_assoc();

if (!$haber) {
    echo "Haber bulunamadı.";
    exit;
}

// İlgili haberleri çek (aynı kategoriden, mevcut haber hariç)
$stmt = $conn->prepare("SELECT * FROM haberler WHERE kategori = ? AND id != ? ORDER BY created_at DESC LIMIT 5");
$stmt->bind_param("si", $kategori, $haber['id']);
$stmt->execute();
$ilgili_haberler = $stmt->get_result();

// Önceki ve sonraki haberleri çek
$stmt = $conn->prepare("SELECT * FROM haberler WHERE id < ? ORDER BY id DESC LIMIT 1");
$stmt->bind_param("i", $haber['id']);
$stmt->execute();
$onceki_haber = $stmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("SELECT * FROM haberler WHERE id > ? ORDER BY id ASC LIMIT 1");
$stmt->bind_param("i", $haber['id']);
$stmt->execute();
$sonraki_haber = $stmt->get_result()->fetch_assoc();

?>

<main class="flex-1 bg-[var(--background-color)]">
    <div class="container mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Ana İçerik -->
            <div class="lg:col-span-8">
                <div class="flex items-center space-x-2 text-sm text-[var(--secondary-color)]">
                    <a class="hover:text-[var(--primary-color)]" href="/<?php echo htmlspecialchars($haber['kategori']); ?>"><?php echo htmlspecialchars($haber['kategori']); ?></a>
                </div>
                <h1 class="mt-4 text-4xl font-extrabold leading-tight text-[var(--primary-color)] md:text-5xl"><?php echo htmlspecialchars($haber['h1']); ?></h1>
                <p class="mt-2 text-lg text-gray-600"><?php echo htmlspecialchars($haber['description']); ?></p>
                <div class="mt-4 flex items-center space-x-4">
                    <p class="text-xs text-[var(--secondary-color)]"><?php echo date('d M Y, H:i', strtotime($haber['created_at'])); ?> tarihinde yayınlandı</p>
                </div>
                <div class="mt-8 w-full overflow-hidden rounded-lg">
                    <img src="/<?php echo htmlspecialchars($haber['image_path']); ?>" alt="<?php echo htmlspecialchars($haber['title']); ?>" class="w-full h-auto object-cover">
                </div>
                <article class="prose prose-lg mt-8 max-w-none text-lg leading-relaxed text-[var(--primary-color)]">
                    <?php echo $haber['main_text']; ?>
                </article>

                <!-- Önceki/Sonraki Haber Navigasyonu -->
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php if ($onceki_haber): ?>
                        <a href="/<?php echo htmlspecialchars($onceki_haber['kategori']); ?>/<?php echo htmlspecialchars($onceki_haber['slug_url']); ?>" class="block group relative">
                            <img src="/<?php echo htmlspecialchars($onceki_haber['image_path']); ?>" alt="<?php echo htmlspecialchars($onceki_haber['title']); ?>" class="w-full h-48 object-cover rounded-lg">
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-lg">
                                <span class="text-white text-lg font-bold">Önceki Haber</span>
                            </div>
                        </a>
                    <?php endif; ?>
                    <?php if ($sonraki_haber): ?>
                        <a href="/<?php echo htmlspecialchars($sonraki_haber['kategori']); ?>/<?php echo htmlspecialchars($sonraki_haber['slug_url']); ?>" class="block group relative">
                            <img src="/<?php echo htmlspecialchars($sonraki_haber['image_path']); ?>" alt="<?php echo htmlspecialchars($sonraki_haber['title']); ?>" class="w-full h-48 object-cover rounded-lg">
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-lg">
                                <span class="text-white text-lg font-bold">Sonraki Haber</span>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Yan Menü (İlgili Haberler) -->
            <aside class="lg:col-span-4 space-y-8">
                <div class="p-6 bg-white rounded-xl shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 font-serif">İlgili Haberler</h3>
                    <ul class="mt-4 space-y-4">
                        <?php while ($ilgili = $ilgili_haberler->fetch_assoc()): ?>
                            <li class="flex items-start gap-4">
                                <img src="/<?php echo htmlspecialchars($ilgili['image_path']); ?>" alt="<?php echo htmlspecialchars($ilgili['title']); ?>" class="w-24 h-24 object-cover rounded-lg">
                                <a href="/<?php echo htmlspecialchars($ilgili['kategori']); ?>/<?php echo htmlspecialchars($ilgili['slug_url']); ?>" class="text-gray-800 hover:text-indigo-600 font-semibold"><?php echo htmlspecialchars($ilgili['title']); ?></a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>