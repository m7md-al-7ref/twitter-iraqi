document.addEventListener('click', function (e) {
    const btn = e.target.closest('.like-btn');
    if (!btn) return;

    const postId = btn.dataset.postId;
    fetch(window.APP_URL + '/like', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'post_id=' + encodeURIComponent(postId)
    })
    .then(r => r.json())
    .then(data => {
        if (!data.ok) return;
        const icon = btn.querySelector('.like-icon');
        const count = btn.querySelector('.like-count');
        btn.classList.toggle('liked', data.liked);
        icon.textContent = data.liked ? '❤️' : '🤍';
        count.textContent = data.count;
    })
    .catch(() => {});
});

// زر المتابعة بدون تحديث الصفحة (اختياري للصفحات اللي تحتاجها)
document.addEventListener('submit', function (e) {
    const form = e.target;
    if (!form.classList.contains('ajax-follow-form')) return;
    e.preventDefault();

    const btn = form.querySelector('.follow-btn');
    const userId = form.querySelector('[name=user_id]').value;

    fetch(window.APP_URL + '/follow', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'user_id=' + encodeURIComponent(userId) + '&ajax=1'
    })
    .then(r => r.json())
    .then(data => {
        if (!data.ok) return;
        btn.textContent = data.following ? 'متابَع' : 'متابعة';
        btn.classList.toggle('following', data.following);
    });
});
