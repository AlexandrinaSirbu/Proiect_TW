document.addEventListener('DOMContentLoaded', function() {
    // Pig Guide Configuration
    const pigGuide = {
        elements: {
            pig: document.createElement('div'),
            bubble: document.createElement('div'),
            closeBtn: document.createElement('button'),
            content: document.createElement('div')
        },
        messages: {
            home: 'Bun venit la PIG! Alege un generator din meniul de sus.',
            numbers: 'Aici poți genera șiruri de numere. Alege valoarea minimă și maximă, lungimea și tipul de sortare.',
            matrix: 'Generator de matrici. Setează dimensiunile și intervalul valorilor.',
            graph: 'Generează grafuri cu număr personalizat de noduri și muchii.',
            string: 'Crează șiruri de caractere cu diverse opțiuni de caractere incluse.'
        },
        currentTab: null,

        init: function() {
            // Create pig element
            this.elements.pig.id = 'pig-guide';
            this.elements.pig.innerHTML = '<img src="/PIG/public/images/img.png" alt="PIG Guide">';

            // Create speech bubble
            this.elements.bubble.id = 'pig-bubble';
            this.elements.closeBtn.id = 'close-pig-guide';
            this.elements.closeBtn.textContent = '×';
            this.elements.closeBtn.addEventListener('click', () => this.hide());

            this.elements.content.id = 'pig-content';

            this.elements.bubble.appendChild(this.elements.closeBtn);
            this.elements.bubble.appendChild(this.elements.content);

            document.body.appendChild(this.elements.pig);
            document.body.appendChild(this.elements.bubble);

            // Set initial message based on current page
            this.detectCurrentTab();
            this.updateMessage();

            // Add hover/animation effects
            this.elements.pig.addEventListener('click', () => this.toggleBubble());
            this.animatePig();

            // Make draggable
            this.makeDraggable(this.elements.pig);

            this.makeResponsive();
            window.addEventListener('resize', () => this.makeResponsive());
        },

        makeResponsive: function() {
            const screenWidth = window.innerWidth;
            const pigElement = this.elements.pig;
            const bubbleElement = this.elements.bubble;

            // Hide completely on small screens
            if (screenWidth < 768) {
                pigElement.style.display = 'none';
                bubbleElement.style.display = 'none';
                return;
            } else {
                pigElement.style.display = 'block';
            }

            // Adjust for medium screens
            if (screenWidth < 1024) {
                pigElement.style.width = '120px';
                pigElement.style.height = '133px';
                bubbleElement.style.width = '180px';
                bubbleElement.style.right = '5px';
                bubbleElement.style.bottom = '160px';
            } else {
                // Reset to default for large screens
                pigElement.style.width = '180px';
                pigElement.style.height = '200px';
                bubbleElement.style.width = '200px';
                bubbleElement.style.right = '10px';
                bubbleElement.style.bottom = '250px';
            }

            // Ensure bubble stays visible in viewport
            const bubbleRect = bubbleElement.getBoundingClientRect();
            if (bubbleRect.left < 0) {
                bubbleElement.style.left = '10px';
                bubbleElement.style.right = 'auto';
            }
        },

        detectCurrentTab: function() {
            const path = window.location.pathname;
            if (path.includes('/numbers')) this.currentTab = 'numbers';
            else if (path.includes('/matrix')) this.currentTab = 'matrix';
            else if (path.includes('/graph')) this.currentTab = 'graph';
            else if (path.includes('/string')) this.currentTab = 'string';
            else this.currentTab = 'home';
        },

        updateMessage: function() {
            this.elements.content.textContent = this.messages[this.currentTab];
        },

        toggleBubble: function() {
            this.elements.bubble.classList.toggle('visible');
        },

        hide: function() {
            this.elements.bubble.classList.remove('visible');
        },

        animatePig: function() {
            let angle = 0;
            setInterval(() => {
                angle = (angle + 2) % 360;
                const rotation = Math.sin(angle * Math.PI / 180) * 5;
                this.elements.pig.style.transform = `rotate(${rotation}deg)`;

                // Gentle bounce
                const bounce = Math.abs(Math.sin(angle * Math.PI / 90)) * 5;
                this.elements.pig.style.bottom = `${30 + bounce}px`;
            }, 50);
        },

        makeDraggable: function(element) {
            let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
            const bubble = this.elements.bubble;
            const pig = this.elements.pig;

            element.onmousedown = dragMouseDown;

            function dragMouseDown(e) {
                e = e || window.event;
                e.preventDefault();
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                e = e || window.event;
                e.preventDefault();
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;

                // Move both pig and bubble together
                pig.style.top = (pig.offsetTop - pos2) + "px";
                pig.style.left = (pig.offsetLeft - pos1) + "px";

                // Calculate bubble position relative to pig
                const pigRect = pig.getBoundingClientRect();
                bubble.style.right = (window.innerWidth - pigRect.right + 10) + "px";
                bubble.style.bottom = (window.innerHeight - pigRect.top + 20) + "px";
            }

            function closeDragElement() {
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }
    };
    // Initialize the pig guide
    pigGuide.init();
});

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('nav');

    if (menuToggle && nav) {
        menuToggle.addEventListener('click', function() {
            nav.classList.toggle('active');
            this.setAttribute('aria-expanded', nav.classList.contains('active'));
        });
    }

    // Close menu when clicking on a link (optional)
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                nav.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    });
});