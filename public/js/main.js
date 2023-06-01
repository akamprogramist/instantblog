const setTheme = (theme) => {
    var mainNav = document.getElementById('mainnav');
    mainNav.classList.remove('navbar-' + document.documentElement.className);
    mainNav.classList.add('navbar-' + theme);
    document.documentElement.className = theme;
    setCookie('theme', theme);
};

function setCookie(name, value) {
    var d = new Date();
    d.setTime(d.getTime() + 365 * 24 * 60 * 60 * 1000);
    var expires = 'expires=' + d.toUTCString();
    document.cookie = name + '=' + value + ';' + expires + ';path=/';
}

function shareButton(button) {
    var link = button.getAttribute('href');
    window.open(
        link,
        '_blank',
        'toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=550,height=450'
    );
}

// Follow Function //
function follow(user) {
    let ownDiv = user.closest('.flwid');
    let followId = ownDiv.querySelector("input[name='follow_id']").value;
    let followBtn = ownDiv.querySelector('.btn');
    let orgBtn = followBtn.innerHTML;
    let token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');
    let errorData = ownDiv.querySelector('.errordata');
    var follow = followURL + '/' + followId;
    fetch(follow, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json, text-plain, */*',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token,
        },
        body: JSON.stringify({
            user: followId,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                if (data.success == 'followed') {
                    followBtn.classList.remove('btn-dark');
                    followBtn.classList.add('btn-secondary');
                    followBtn.innerHTML = unfollowtxt;
                } else {
                    followBtn.classList.remove('btn-secondary');
                    followBtn.classList.add('btn-dark');
                    followBtn.innerHTML = followtxt;
                }
                if (errorData) {
                    errorData.remove();
                }
            } else {
                if (errorData) {
                    errorData.remove();
                }
            }
        })
        .catch((error) => {
            console.error('error:', error);
        });
}

var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],
    ['blockquote', 'code-block', 'link'],
    [{ list: 'ordered' }, { list: 'bullet' }],
    [{ color: [] }, { background: [] }],
    ['clean'],
];
