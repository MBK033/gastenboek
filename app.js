const boxes = document.querySelectorAll('.bericht');
const audio = new Audio('boing-101318.mp3');

window.addEventListener('scroll', checkBoxes);

function checkBoxes() {
    const threshold = window.innerHeight / 5 * 5;

    boxes.forEach(box => {
        if (box.getBoundingClientRect().top < threshold) {
            box.classList.add('show');
            // audio.play();
        }
        if (box.getBoundingClientRect().top > window.innerHeight - 300) {
            box.classList.remove('show');
        }
    });
}
