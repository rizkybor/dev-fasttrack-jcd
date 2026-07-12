from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(args=['--no-sandbox'])
    page = browser.new_page(viewport={'width':320,'height':800})
    page.goto("http://127.0.0.1:8123/badan-usaha/1", wait_until='networkidle', timeout=20000)
    page.wait_for_timeout(800)
    close_btn = page.locator('.fixed.inset-0.z-\\[100\\] button')
    if close_btn.count() > 0:
        try:
            close_btn.first.click(timeout=3000)
            page.wait_for_timeout(400)
        except Exception:
            pass

    base_sw = page.evaluate("document.documentElement.scrollWidth")
    print("baseline scrollWidth:", base_sw)

    # hide hero section
    result = page.evaluate("""
    () => {
      const results = {};
      const sections = document.querySelectorAll('section');
      sections.forEach((s, i) => {
        const prevDisplay = s.style.display;
        s.style.display = 'none';
        results['section_' + i + '_' + (s.id || s.className.slice(0,30))] = document.documentElement.scrollWidth;
        s.style.display = prevDisplay;
      });
      return results;
    }
    """)
    for k, v in result.items():
        print(k, "->", v)
    browser.close()
