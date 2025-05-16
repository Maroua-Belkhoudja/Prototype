document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-times');
            icon.classList.toggle('fa-bars');
        });
        
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', function() {
                navLinks.classList.remove('active');
                menuToggle.querySelector('i').classList.remove('fa-times');
                menuToggle.querySelector('i').classList.add('fa-bars');
            });
        });
    }
    

    // Language Switcher Functionality
        console.log('DOM fully loaded'); // Debug point 1
        
        const langBtn = document.querySelector('.language-btn');
        const langDropdown = document.querySelector('.language-dropdown');
        const currentLang = document.querySelector('.current-language');
        const html = document.documentElement;
    
        if (!langBtn || !langDropdown || !currentLang) {
            console.error('Missing critical elements:', {langBtn, langDropdown, currentLang});
            return;
        }
    
        console.log('Elements found successfully'); // Debug point 2
    
        // Enhanced translation function
        function changeLanguage(lang) {
            console.log('Attempting to change language to:', lang); // Debug point 3
            
            // Set HTML attributes
            html.lang = lang;
            html.dir = lang === 'ar' ? 'rtl' : 'ltr';
            console.log('HTML attributes set:', {lang: html.lang, dir: html.dir}); // Debug point 4
    
            // Update UI
            currentLang.textContent = lang.toUpperCase();
            
            // Update all translatable elements
            const translatableElements = document.querySelectorAll('[data-translate]');
            console.log(`Found ${translatableElements.length} translatable elements`); // Debug point 5
            
            translatableElements.forEach(element => {
                const key = element.getAttribute('data-translate');
                if (translations[lang] && translations[lang][key]) {
                    console.log(`Translating ${key} to:`, translations[lang][key]); // Debug point 6
                    element.textContent = translations[lang][key];
                } else {
                    console.warn(`Missing translation for key "${key}" in language "${lang}"`);
                }
            });
            
            // Save preference
            localStorage.setItem('lang', lang);
            console.log('Language changed and saved successfully'); // Debug point 7
        }
    
        // Load saved language or default to English
        const savedLang = localStorage.getItem('lang') || 'en';
        console.log('Loading saved language:', savedLang); // Debug point 8
        changeLanguage(savedLang);
    
        // Event listeners
        langBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isVisible = langDropdown.style.visibility === 'visible';
            langDropdown.style.opacity = isVisible ? '0' : '1';
            langDropdown.style.visibility = isVisible ? 'hidden' : 'visible';
            console.log('Dropdown toggled:', !isVisible); // Debug point 9
        });
    
        document.querySelectorAll('.language-dropdown li').forEach(item => {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                const lang = this.getAttribute('data-lang');
                console.log('Language selected:', lang); // Debug point 10
                changeLanguage(lang);
                langDropdown.style.opacity = '0';
                langDropdown.style.visibility = 'hidden';
            });
        });
    
        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            langDropdown.style.opacity = '0';
            langDropdown.style.visibility = 'hidden';
        });

  
});