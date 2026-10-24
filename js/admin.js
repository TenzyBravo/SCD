/* Staff area behaviour. Kept in a file because the Content-Security-Policy blocks inline scripts. */
document.addEventListener('submit', (e) => {
  const message = e.target.getAttribute('data-confirm');
  if (message && !window.confirm(message)) {
    e.preventDefault();
  }
});
