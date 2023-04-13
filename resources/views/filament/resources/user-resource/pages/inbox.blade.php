<x-filament::page>
    <div class="fixed bottom-4 right-4 z-50 draggable-parent">        
        <x-tabler-drag-drop-2 class="h-5 w-5 text-gray-400 handle"/>
        <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <svg class="w-10 h-10 mb-2 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"></path><path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"></path></svg>
            <a href="#">
                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Need a help in Claim?</h5>
            </a>
            <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">Go to this step by step guideline process on how to certify for your weekly benefits:</p>
            <a href="#" class="inline-flex items-center text-blue-600 hover:underline">
                See our guideline
                <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path><path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path></svg>
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const draggableParent = document.querySelector('.draggable-parent');
            const handle = document.querySelector('.handle');

            let isDragging = false;
            let currentX;
            let currentY;
            let initialX;
            let initialY;
            let xOffset = 0;
            let yOffset = 0;

            draggableParent.addEventListener('mousedown', dragStart);
            draggableParent.addEventListener('mouseup', dragEnd);

            function dragStart(e) {
                if (e.target === handle) {
                    initialX = e.clientX - xOffset;
                    initialY = e.clientY - yOffset;

                    isDragging = true;
                    draggableParent.classList.add('dragging');
                }
            }

            function dragEnd(e) {
                initialX = currentX;
                initialY = currentY;

                isDragging = false;
                draggableParent.classList.remove('dragging');
            }

            function drag(e) {
                if (isDragging) {
                    e.preventDefault();

                    currentX = e.clientX - initialX;
                    currentY = e.clientY - initialY;

                    xOffset = currentX;
                    yOffset = currentY;

                    setTranslate(currentX, currentY, draggableParent);
                }
            }

            function setTranslate(xPos, yPos, el) {
                el.style.transform = `translate3d(${xPos}px, ${yPos}px, 0)`;

                // Update the position of the handle element as well
                handle.style.transform = `translate3d(${-xPos}px, ${-yPos}px, 0)`;
            }

            document.addEventListener('mousemove', drag);
        });
    </script>

</x-filament::page>
