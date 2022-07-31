function toggleTOC() {
  let toggle    = document.getElementById('toc-toggle');
  let openClose = toggle.getElementsByTagName('span')[0];
  let toc       = document.getElementById('toc');

  var inner    = 'close';
  var expanded = 'true';
  if (toggle.getAttribute('aria-expanded') === 'true') {
    inner    = 'open';
    expanded = 'false';

  }

  toggle.setAttribute('aria-expanded', expanded);
  openClose.innerHTML = inner;

  toc.setAttribute('data-open', expanded);
}

document.addEventListener('DOMContentLoaded', function() {
  window.addEventListener('scroll', function() {
    let shouldClose = document.getElementById('toc-toggle').getAttribute('aria-expanded');
    if (shouldClose === 'true') {
      toggleTOC();
    }
  });
});
