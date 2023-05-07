<div x-data="{ open: false }">
    <div class="py-3">
        <button @click="open = !open" class="flex justify-between items-center">
            <span class="font-bold mr-1">Show Subtask</span>     
        </button>
        <div x-show="open" class="bg-white p-4 rounded-lg">
            <!-- Collapsible content goes here -->
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor arcu risus, at efficitur elit hendrerit non. Vestibulum tincidunt justo vel nulla vestibulum, sit amet molestie odio ultricies. Donec at purus id urna feugiat congue vel vel eros. Aliquam quis ligula vel orci varius faucibus. Integer fringilla at justo a convallis. Integer euismod dolor sit amet magna rutrum ultrices. Duis convallis orci eu tellus vehicula, at ultricies lacus lobortis. Sed a metus non elit hendrerit rutrum.
        </div>
    </div>
</div>