/* Copy-to-clipboard for code snippets. */
document.querySelectorAll('.snippet').forEach(function (block) {
	var pre = block.querySelector('pre');
	if (!pre) { return; }
	var btn = document.createElement('button');
	btn.type = 'button';
	btn.className = 'copy';
	btn.textContent = 'Copy';
	btn.addEventListener('click', function () {
		navigator.clipboard.writeText(pre.innerText).then(function () {
			btn.textContent = 'Copied';
			setTimeout(function () { btn.textContent = 'Copy'; }, 1600);
		});
	});
	block.appendChild(btn);
});
