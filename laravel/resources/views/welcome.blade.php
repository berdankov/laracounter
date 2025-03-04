<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIKA</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            font-family: 'Arial', sans-serif;
            overflow: hidden;
        }

        .slide-container {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-position: center;
            background-repeat: no-repeat;
            transition: opacity 1s ease-in-out;
        }

        .slide-container:not(.first-slide) {
            background-size: contain;
        }

        .hidden {
            opacity: 0;
            z-index: -1;
        }

        .visible {
            opacity: 1;
            z-index: 1;
        }

        .counter-container {
            background-color: #45ff9e;
            color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            align-items: center;
            font-size: 15rem;
        }

        .counter-container img {
            height: 220px;
            width: 220px;
            margin-right: 40px;
        }

        .counter {
            display: flex;
            align-items: center;
        }

        .current-count {
            margin-right: 10px;
        }

        .no-space {
            font-family: fantasy;
            color: red;
            font-size: 20rem;
            margin-top: 20px;
            visibility: hidden;
            -webkit-text-stroke: 5px #FFFFFF;
            text-stroke: 1px #FFFFFF;
            font-weight: 800;
            position: absolute;
            bottom: -9px;
        }

        /* Медиазапросы для уменьшения размеров на мобильных устройствах */
        @media (max-width: 768px) {
            .counter-container {
                padding: 10px;
                font-size: 7.5rem;
            }

            .counter-container img {
                height: 67px;
                width: 67px;
                margin-right: 20px;
            }

            .counter {
                font-size: 2rem;
            }

            .current-count {
                margin-right: 5px;
            }

            .no-space {
                font-size: 10rem;
                margin-top: 10px;
                -webkit-text-stroke: 2.5px #FFFFFF;
                text-stroke: 0.5px #FFFFFF;
                bottom: -4.5px;
            }
        }
    </style>
    <script>
        async function fetchZoneCount() {
            try {
                const response = await fetch('/zone-count');
                const data = await response.json();
                if (response.ok) {
                    const count = data.count > 450 ? 450 : data.count;
                    document.getElementById('zoneCount').innerText = count.toString().padStart(3, '0');
                    if (count >= 450) {
                        document.getElementById('noSpaceMessage').style.visibility = 'visible';
                    } else {
                        document.getElementById('noSpaceMessage').style.visibility = 'hidden';
                    }
                } else {
                    console.error('Error fetching data:', data.error);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        setInterval(fetchZoneCount, 10000);
        window.onload = fetchZoneCount;

        async function checkFileExists(url) {
            try {
                const response = await fetch(url, { method: 'HEAD' });
                return response.ok;
            } catch (error) {
                console.error('Error checking file:', error);
                return false;
            }
        }

        async function initializeSlides() {
            const basePath = '{{ asset('images/') }}';
            const slideNames = [
                'slide1.png', 'slide2.png', 'slide3.png',
                'slide4.png', 'slide5.png', 'slide6.png',
                'slide7.png', 'slide8.png', 'slide9.png'
            ];
            const slides = [];

            for (const slide of slideNames) {
                const exists = await checkFileExists(`${basePath}/${slide}`);
                if (exists) {
                    slides.push(`${basePath}/${slide}`);
                }
            }

            let currentSlide = 0;

            function showSlide(index) {
                const slideContainers = document.querySelectorAll('.slide-container');
                slideContainers.forEach((container, idx) => {
                    if (idx === index) {
                        container.style.backgroundImage = `url(${slides[idx]})`;
                        container.classList.add('visible');
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                        container.classList.remove('visible');
                    }
                });
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }

            if (slides.length > 0) {
                showSlide(currentSlide);
                setInterval(nextSlide, 1500000);
            }
        }

        document.addEventListener('DOMContentLoaded', initializeSlides);
    </script>
</head>
<body>
    <div class="slide-container visible first-slide">
        <div class="counter-container">
            <img src="{{ asset('images/swimmer.png') }}" alt="Swimmer Icon">
            <div class="counter">
                <div class="current-count" id="zoneCount">000</div>
                <div>- 450</div>
            </div>
        </div>
        <div id="noSpaceMessage" class="no-space">НЕТ МЕСТ</div>
    </div>
    <div class="slide-container hidden"></div>
    <div class="slide-container hidden"></div>
    <div class="slide-container hidden"></div>
    <div class="slide-container hidden"></div>
    <div class="slide-container hidden"></div>
    <div class="slide-container hidden"></div>
    <div class="slide-container hidden"></div>
    <div class="slide-container hidden"></div>
</body>
</html>
