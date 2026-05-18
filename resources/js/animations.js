document.addEventListener('DOMContentLoaded', () => {

    // Figuras geométricas — parallax por cursor
    (function () {
        const allShapes = document.querySelectorAll('.geo-wrap > div');
        if (!allShapes.length) return;

        allShapes.forEach(el => {
            el.style.animation  = 'none';
            el.style.transition = 'transform 0.9s cubic-bezier(.25,.46,.45,.94)';
        });

        const depths = [0.028, -0.018, 0.042, -0.026, 0.020];

        document.querySelectorAll('section').forEach(section => {
            const shapes = [...section.querySelectorAll('.geo-wrap > div')];
            if (!shapes.length) return;

            let raf;

            section.addEventListener('mousemove', e => {
                if (raf) cancelAnimationFrame(raf);
                raf = requestAnimationFrame(() => {
                    const r  = section.getBoundingClientRect();
                    const dx = e.clientX - r.left  - r.width  * 0.5;
                    const dy = e.clientY - r.top   - r.height * 0.5;
                    shapes.forEach((s, i) => {
                        const d = depths[i % depths.length];
                        s.style.transform = `translate(${dx * d}px, ${dy * d}px)`;
                    });
                });
            });

            section.addEventListener('mouseleave', () => {
                if (raf) cancelAnimationFrame(raf);
                shapes.forEach(s => { s.style.transform = 'translate(0,0)'; });
            });
        });
    })();

    const io = new IntersectionObserver(
        entries => entries.forEach(e => {
            e.target.classList.toggle('is-visible', e.isIntersecting);
        }),
        { threshold: 0.12 }
    );
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
});
