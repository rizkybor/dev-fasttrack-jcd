from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(args=['--no-sandbox'])
    page = browser.new_page(viewport={'width':320,'height':800})
    page.goto("http://127.0.0.1:8123/badan-usaha/1", wait_until='networkidle', timeout=20000)
    page.wait_for_timeout(1000)
    close_btn = page.locator('.fixed.inset-0.z-\\[100\\] button')
    if close_btn.count() > 0:
        try:
            close_btn.first.click(timeout=3000)
            page.wait_for_timeout(400)
        except Exception as e:
            print("close err", e)

    vw = page.evaluate("window.innerWidth")
    sw = page.evaluate("document.documentElement.scrollWidth")
    print("vw", vw, "scrollWidth", sw)

    info = page.evaluate("""
    () => {
      const vw = window.innerWidth;
      let widest = null;
      document.querySelectorAll('*').forEach(el => {
        const r = el.getBoundingClientRect();
        if (r.right > vw + 2 && (!widest || r.right > widest.right)) {
          widest = {tag: el.tagName, cls: el.className.toString().slice(0,150), left: Math.round(r.left), right: Math.round(r.right), width: Math.round(r.width), text: (el.textContent||'').slice(0,60)};
        }
      });
      return widest;
    }
    """)
    print("widest:", info)
    browser.close()
