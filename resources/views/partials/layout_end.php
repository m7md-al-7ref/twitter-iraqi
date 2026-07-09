    </main>

    <aside class="right-panel">
        <form action="<?= url('/search') ?>" method="GET" class="search-box">
            <span>🔍</span>
            <input type="text" name="q" placeholder="دور بتويتر العراقي..." value="<?= e($_GET['q'] ?? '') ?>">
        </form>

        <div class="panel-box">
            <div class="panel-title">منو تتابع؟</div>
            <?php $sugg = $sugg ?? Follow::suggestions($user['id'], 5); ?>
            <?php if (empty($sugg)): ?>
                <p style="color:#536471;font-size:14px;">ماكو اقتراحات هسه</p>
            <?php endif; ?>
            <?php foreach ($sugg as $s): ?>
                <div class="suggestion-item">
                    <a href="<?= url('/profile/' . $s['username']) ?>">
                        <img class="avatar avatar-sm" src="<?= $s['avatar'] ? url($s['avatar']) : 'https://api.dicebear.com/7.x/initials/svg?seed=' . urlencode($s['name']) ?>" alt="">
                    </a>
                    <div class="suggestion-info">
                        <a href="<?= url('/profile/' . $s['username']) ?>">
                            <div class="suggestion-name"><?= e($s['name']) ?></div>
                        </a>
                        <div class="suggestion-username">@<?= e($s['username']) ?></div>
                    </div>
                    <form action="<?= url('/follow') ?>" method="POST">
                        <input type="hidden" name="user_id" value="<?= $s['id'] ?>">
                        <button class="follow-btn" type="submit">متابعة</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <p style="color:#536471;font-size:13px;padding:0 8px;">تويتر عراقي © <?= date('Y') ?> — مشروع تجريبي 🇮🇶</p>
    </aside>

</div>
<script>window.APP_URL = "<?= url('') ?>".replace(/\/$/, '');</script>
<script src="<?= url('resources/js/app.js') ?>"></script>
</body>
</html>
