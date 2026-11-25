<?php
declare(strict_types=1);
session_start();

$pages = [
    'domov' => 'Domov',
    'aktuality' => 'Aktuality',
    'zazitky' => 'Čo sme zažili',
    'projekty' => 'Aktivity a projekty',
    'onas' => 'Kto sme?',
    'kontakt' => 'Kontakt',
];
$page = isset($_GET['page']) && array_key_exists($_GET['page'], $pages) ? $_GET['page'] : 'domov';

$news = [
    [
        'date' => '05. 12. 2026',
        'tag' => 'Výlet',
        'title' => 'Pripravujeme výlet do Bratislavy',
        'place' => 'Bratislava',
        'excerpt' => 'Čaká nás spoločný výlet za zaujímavou výstavou v budove Slovenského rozhlasu. Ak nám to počasie dovolí, pozrieme sa aj na vianočné trhy.',
        'image' => 'https://images.unsplash.com/photo-1513622470522-26c3c8a854bc?auto=format&fit=crop&w=1000&q=85',
    ],
    [
        'date' => '20. 12. 2026',
        'tag' => 'Pomáhame',
        'title' => 'Ondrova vianočná kapustnica',
        'place' => 'Stará Turá',
        'excerpt' => 'Aj tento rok spojíme sily a pomôžeme pripraviť vianočnú kapustnicu pre ľudí, ktorí to potrebujú. Každá ochotná ruka sa počíta.',
        'image' => 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=1000&q=85',
    ],
    [
        'date' => '23. 12. 2026',
        'tag' => 'Komunita',
        'title' => 'Urobme si štedrejšie Vianoce',
        'place' => 'Stará Turá',
        'excerpt' => 'Radi sa pridávame k ľuďom, ktorí chcú spríjemniť Vianoce seniorom a rodinám s deťmi v náročnej situácii.',
        'image' => 'https://images.unsplash.com/photo-1512389142860-9c449e58a543?auto=format&fit=crop&w=1000&q=85',
    ],
];

$projects = [
    ['icon'=>'🌍','title'=>'Cesta okolo sveta','text'=>'Spoznávame krajiny, kultúry a zaujímavosti sveta hravou a zážitkovou formou.'],
    ['icon'=>'🎬','title'=>'Premietaj aj ty s FÉNIXom!','text'=>'Priestor pre spoločné filmové zážitky, nápady a stretnutia.'],
    ['icon'=>'🏡','title'=>'Miesto, kde žijem','text'=>'Objavujeme naše okolie a učíme sa vnímať miesto, ktoré nazývame domovom.'],
    ['icon'=>'🌱','title'=>'Naše Ekomesto','text'=>'Rozvíjame vzťah k prírode, udržateľnosti a zodpovednému správaniu.'],
    ['icon'=>'🧭','title'=>'Preži v prírode','text'=>'Učíme sa spolupracovať, objavovať a tráviť čas aktívne vonku.'],
    ['icon'=>'🛠️','title'=>'Obnov si svoj exponát','text'=>'Tvoríme, opravujeme a dávame veciam nový život.'],
];

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$sent = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'kontakt') {
    $name = trim((string)($_POST['name'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $message = trim((string)($_POST['message'] ?? ''));
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') {
        $error = 'Skontrolujte, prosím, všetky polia formulára.';
    } else {
        // Doplňte adresu a povoľte mail() na hostingu, ak chcete odosielať správy priamo z webu.
        $to = 'staratura@do-fenix.sk';
        $subject = 'Správa z webovej stránky – ' . $name;
        $body = "Meno: {$name}\nE-mail: {$email}\n\nSpráva:\n{$message}";
        $headers = "From: web@do-fenix.sk\r\nReply-To: {$email}\r\nContent-Type: text/plain; charset=UTF-8";
        if (@mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $body, $headers)) {
            $sent = true;
        } else {
            $error = 'Formulár je pripravený, ale server momentálne nevie odoslať e-mail. Napíšte nám, prosím, priamo na staratura@do-fenix.sk.';
        }
    }
}
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#176b4b">
    <meta name="description" content="Detská organizácia FÉNIX – Základná organizácia Stará Turá. Zážitky, projekty, výlety a aktivity pre deti a mladých.">
    <title><?= e($pages[$page]) ?> | FÉNIX Stará Turá</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="topline">
    <div class="container topline-inner">
        <span>🌿 Spolu tvoríme zážitky už celé generácie</span>
        <a href="mailto:staratura@do-fenix.sk">staratura@do-fenix.sk</a>
    </div>
</div>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="index.php" aria-label="FÉNIX Stará Turá – domov">
            <span class="brand-mark">F<span>✦</span></span>
            <span class="brand-copy"><strong>FÉNIX</strong><small>STARÁ TURÁ</small></span>
        </a>
        <button class="menu-toggle" aria-label="Otvoriť navigáciu" aria-expanded="false"><span></span><span></span><span></span></button>
        <nav class="main-nav" aria-label="Hlavná navigácia">
            <?php foreach ($pages as $key => $label): ?>
                <a class="<?= $page === $key ? 'active' : '' ?>" href="index.php?page=<?= e($key) ?>"><?= e($label) ?></a>
            <?php endforeach; ?>
            <a class="nav-cta" href="index.php?page=kontakt">Napíšte nám <span>↗</span></a>
        </nav>
    </div>
</header>

<main>
<?php if ($page === 'domov'): ?>
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="container hero-content">
            <div class="eyebrow"><span></span> DETSKÁ ORGANIZÁCIA FÉNIX · STARÁ TURÁ</div>
            <h1>Každý deň môže byť <em>dobrodružstvo.</em></h1>
            <p>Priateľstvá, nové zážitky a nápady, ktoré menia svet okolo nás. Objav, čo všetko spolu vo FÉNIXe zažívame.</p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="index.php?page=projekty">Objav naše aktivity <span>↗</span></a>
                <a class="btn btn-ghost" href="index.php?page=onas">Spoznaj nás</a>
            </div>
            <div class="hero-note"><span class="note-icon">✳</span><span><strong>30 rokov</strong><small>spoločných zážitkov a priateľstiev</small></span></div>
        </div>
        <div class="hero-sticker">BUĎ<br>FÉNIX! <span>✦</span></div>
    </section>

    <section class="intro-section section-pad">
        <div class="container intro-grid">
            <div>
                <div class="eyebrow"><span></span> VITAJ VO FÉNIXE</div>
                <h2>Miesto, kde sa z<br><em>nápadov stávajú zážitky.</em></h2>
            </div>
            <div class="intro-copy">
                <p>Sme partia ľudí, ktorých baví objavovať, tvoriť, pomáhať a tráviť čas spolu. Vo FÉNIXe dávame priestor zvedavosti, kamarátstvu aj dobrým nápadom.</p>
                <a class="text-link" href="index.php?page=onas">Viac o našej organizácii <span>→</span></a>
            </div>
        </div>
        <div class="container feature-strip">
            <div class="feature"><span>01</span><strong>Objavujeme</strong><small>Svet okolo nás</small></div>
            <div class="feature"><span>02</span><strong>Tvoríme</strong><small>Nové nápady</small></div>
            <div class="feature"><span>03</span><strong>Pomáhame</strong><small>Keď je to potrebné</small></div>
            <div class="feature"><span>04</span><strong>Zažívame</strong><small>Spoločne a naplno</small></div>
        </div>
    </section>

    <section class="news-section section-pad">
        <div class="container">
            <div class="section-heading">
                <div><div class="eyebrow"><span></span> ČO JE NOVÉ</div><h2>Život vo <em>FÉNIXe.</em></h2></div>
                <a class="text-link" href="index.php?page=aktuality">Všetky aktuality <span>→</span></a>
            </div>
            <div class="news-grid">
                <?php foreach ($news as $item): ?>
                <article class="news-card">
                    <a class="news-image" href="index.php?page=aktuality"><img src="<?= e($item['image']) ?>" alt="" loading="lazy"><span class="news-tag"><?= e($item['tag']) ?></span></a>
                    <div class="news-body"><div class="meta"><?= e($item['date']) ?> <span>·</span> <?= e($item['place']) ?></div><h3><a href="index.php?page=aktuality"><?= e($item['title']) ?></a></h3><p><?= e($item['excerpt']) ?></p><a class="arrow-link" href="index.php?page=aktuality" aria-label="Viac o aktualite">↗</a></div>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="projects-section section-pad">
        <div class="container">
            <div class="section-heading">
                <div><div class="eyebrow light"><span></span> NÁPADY, KTORÉ ŽIJÚ</div><h2>Čo všetko <em>podnikáme?</em></h2></div>
                <a class="text-link light-link" href="index.php?page=projekty">Všetky projekty <span>→</span></a>
            </div>
            <div class="project-grid">
                <?php foreach (array_slice($projects, 0, 3) as $project): ?>
                <article class="project-card"><span class="project-icon"><?= e($project['icon']) ?></span><h3><?= e($project['title']) ?></h3><p><?= e($project['text']) ?></p><span class="project-arrow">↗</span></article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container cta-box"><div><div class="eyebrow"><span></span> POĎ DO TOHO S NAMI</div><h2>Najlepšie zážitky<br>vznikajú <em>spolu.</em></h2></div><div><p>Máš otázku, nápad alebo sa chceš dozvedieť viac? Budeme radi, keď sa nám ozveš.</p><a class="btn btn-primary" href="index.php?page=kontakt">Kontaktuj nás <span>↗</span></a></div></div>
    </section>

<?php elseif ($page === 'aktuality'): ?>
    <section class="page-hero"><div class="container"><div class="eyebrow"><span></span> DEJE SA U NÁS</div><h1>Naše <em>aktuality.</em></h1><p>Novinky, pozvánky a všetko dôležité z diania vo FÉNIXe.</p></div></section>
    <section class="section-pad"><div class="container news-grid news-grid-page">
        <?php foreach ($news as $item): ?>
        <article class="news-card"><div class="news-image"><img src="<?= e($item['image']) ?>" alt="" loading="lazy"><span class="news-tag"><?= e($item['tag']) ?></span></div><div class="news-body"><div class="meta"><?= e($item['date']) ?> <span>·</span> <?= e($item['place']) ?></div><h3><?= e($item['title']) ?></h3><p><?= e($item['excerpt']) ?></p></div></article>
        <?php endforeach; ?>
    </div></section>

<?php elseif ($page === 'zazitky'): ?>
    <section class="page-hero"><div class="container"><div class="eyebrow"><span></span> SPOMIENKY, KTORÉ ZOSTÁVAJÚ</div><h1>Čo sme <em>zažili.</em></h1><p>Každý výlet, stretnutie či spoločný projekt je ďalší príbeh do našej FÉNIXáckej kroniky.</p></div></section>
    <section class="section-pad"><div class="container story-layout"><div class="story-photo"><img src="https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&w=1200&q=85" alt="Skupina mladých ľudí na spoločnej aktivite"></div><div class="story-copy"><div class="eyebrow"><span></span> SPOLOČNÉ CHVÍLE</div><h2>Nie je to len program.<br><em>Je to zážitok.</em></h2><p>Výlety, tvorivé dielne, dobrovoľnícke aktivity a chvíle, na ktoré sa dobre spomína. Práve z nich vznikajú priateľstvá a príbehy, ktoré nás spájajú.</p><a class="btn btn-primary" href="index.php?page=kontakt">Chcem vedieť viac <span>↗</span></a></div></div></section>

<?php elseif ($page === 'projekty'): ?>
    <section class="page-hero"><div class="container"><div class="eyebrow"><span></span> NÁPADY V POHYBE</div><h1>Aktivity a <em>projekty.</em></h1><p>Učíme sa novým veciam, objavujeme svet a meníme dobré nápady na skutočnosť.</p></div></section>
    <section class="section-pad"><div class="container project-grid project-grid-light">
        <?php foreach ($projects as $project): ?>
        <article class="project-card"><span class="project-icon"><?= e($project['icon']) ?></span><h3><?= e($project['title']) ?></h3><p><?= e($project['text']) ?></p><span class="project-arrow">↗</span></article>
        <?php endforeach; ?>
    </div></section>

<?php elseif ($page === 'onas'): ?>
    <section class="page-hero"><div class="container"><div class="eyebrow"><span></span> KTO SME</div><h1>Malí aj veľkí.<br><em>Jedna FÉNIXácka partia.</em></h1><p>Detská organizácia FÉNIX – Základná organizácia Stará Turá.</p></div></section>
    <section class="section-pad"><div class="container story-layout"><div class="story-photo"><img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?auto=format&fit=crop&w=1200&q=85" alt="Deti pri spoločnej aktivite"></div><div class="story-copy"><div class="eyebrow"><span></span> NAŠA ORGANIZÁCIA</div><h2>Rastieme cez<br><em>zážitky a priateľstvá.</em></h2><p>Vo FÉNIXe vytvárame priestor na zmysluplné trávenie voľného času, nové skúsenosti a spoločné aktivity. Veríme, že každý dobrý nápad môže priniesť niečo pozitívne do nášho okolia.</p><p>Naša základná organizácia pôsobí v Starej Turej a je súčasťou Detskej organizácie FÉNIX.</p><a class="text-link" href="https://www.do-fenix.sk/" target="_blank" rel="noopener">Celoslovenská organizácia FÉNIX <span>↗</span></a></div></div></section>

<?php elseif ($page === 'kontakt'): ?>
    <section class="page-hero"><div class="container"><div class="eyebrow"><span></span> OZVITE SA NÁM</div><h1>Budeme radi,<br><em>keď sa ozveš.</em></h1><p>Otázky, nápady alebo záujem o naše aktivity? Napíš nám.</p></div></section>
    <section class="section-pad"><div class="container contact-layout"><div class="contact-info"><div class="eyebrow"><span></span> KONTAKTNÉ INFORMÁCIE</div><h2>Spojenie na<br><em>FÉNIX Stará Turá.</em></h2><div class="contact-detail"><span class="detail-icon">✉</span><div><small>E-mail</small><a href="mailto:staratura@do-fenix.sk">staratura@do-fenix.sk</a></div></div><div class="contact-detail"><span class="detail-icon">⌖</span><div><small>Organizácia</small><strong>Detská organizácia FÉNIX<br>Základná organizácia Stará Turá</strong></div></div><a class="text-link" href="https://www.do-fenix.sk/" target="_blank" rel="noopener">Web DO FÉNIX <span>↗</span></a></div>
        <form class="contact-form" method="post" action="index.php?page=kontakt">
            <h3>Napíš nám správu</h3><p>Vyplň krátky formulár a ozveme sa ti.</p>
            <?php if ($sent): ?><div class="form-message success">Správa bola úspešne odoslaná. Ďakujeme!</div><?php elseif ($error !== ''): ?><div class="form-message error"><?= e($error) ?></div><?php endif; ?>
            <label for="name">Meno</label><input id="name" name="name" type="text" placeholder="Ako sa voláš?" required>
            <label for="email">E-mail</label><input id="email" name="email" type="email" placeholder="tvoj@email.sk" required>
            <label for="message">Správa</label><textarea id="message" name="message" rows="5" placeholder="Čo by si nám chcel/a napísať?" required></textarea>
            <button class="btn btn-primary" type="submit">Odoslať správu <span>↗</span></button>
            <small class="privacy-note">Odoslaním formulára súhlasíš s tým, že použijeme tvoje údaje iba na odpoveď na správu.</small>
        </form></div></section>
<?php endif; ?>
</main>

<footer class="site-footer">
    <div class="container footer-main">
        <div class="footer-brand"><a class="brand brand-footer" href="index.php"><span class="brand-mark">F<span>✦</span></span><span class="brand-copy"><strong>FÉNIX</strong><small>STARÁ TURÁ</small></span></a><p>Priateľstvá, zážitky a nápady,<br>ktoré nás posúvajú ďalej.</p></div>
        <div class="footer-col"><strong>Objavuj</strong><a href="index.php?page=aktuality">Aktuality</a><a href="index.php?page=zazitky">Čo sme zažili</a><a href="index.php?page=projekty">Aktivity a projekty</a></div>
        <div class="footer-col"><strong>FÉNIX</strong><a href="index.php?page=onas">Kto sme?</a><a href="index.php?page=kontakt">Kontakt</a><a href="https://www.do-fenix.sk/" target="_blank" rel="noopener">DO FÉNIX ↗</a></div>
        <div class="footer-contact"><strong>Buďme v kontakte.</strong><a href="mailto:staratura@do-fenix.sk">staratura@do-fenix.sk</a><span>Stará Turá, Slovensko</span></div>
    </div>
    <div class="container footer-bottom"><span>© <?= date('Y') ?> FÉNIX Stará Turá. Všetky práva vyhradené.</span><span>Vytvorené s <b>♥</b> pre komunitu.</span></div>
</footer>
<script src="assets/js/main.js"></script>
</body>
</html>
