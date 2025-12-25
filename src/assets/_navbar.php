<nav class="fixed top-0 left-0 right-0 px-7 pb-1 bg-black z-10 flex justify-between items-center h-[3.8em]">

    <div class="flex items-center">
        <img src="./assets/images/icons/menu.svg" class="h-[1.1rem] -mr-1 w-auto cursor-pointer" id="menu-icon"
            alt="menu-icon">
        <img src="./assets/images/logos/steamstube-logo.svg" class="h-8 ml-7 cursor-pointer" alt="steamstube-logo"
            id="domain-logo">
        <span class="text-[1.3rem] font-youtube ml-0.5 text-gray-200 cursor-pointer" id="domain-name">
            <?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?>
        </span>
        <?php if (!empty($_ENV['BETA']) && filter_var($_ENV['BETA'], FILTER_VALIDATE_BOOLEAN)): ?>
            <span
                class="text-[0.6rem] font-youtube uppercase ml-[0.1rem] -mt-2 px-1 py-0.5 rounded text-pink-700 pointer-events-none">beta</span>
        <?php endif; ?>
    </div>

    <div
        class="flex flex-1 justify-center items-center px-8 mt-1 ml-auto mr-auto max-[1100px]:justify-start max-[750px]:hidden">
        <div class="flex items-center w-full max-w-[41rem] border-2 border-neutral-900 rounded-full px-5 py-[0.5rem]">
            <img src="./assets/images/icons/search.svg" class="h-[1.2rem] mr-2" alt="search-icon">
            <input type="text"
                placeholder="Search <?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?> or paste your code..."
                class="flex-1 placeholder:text-gray-400 font-light text-gray-200 bg-transparent border-none outline-none text-sm tracking-wide truncate min-w-0">
            <button class="ml-2 cursor-pointer">
                <img src="./assets/images/icons/search-filter-icon.svg" class="h-5" alt="search-filter-icon">
            </button>
        </div>
    </div>

    <div class="flex items-center mt-0 relative">
        <button class="hidden max-[750px]:inline-flex items-center justify-center cursor-pointer" id="mobileSearchBtn">
            <img src="./assets/images/icons/mobile-search-icon.svg" class="h-5 w-auto pl-5" alt="mobile-search-icon">
        </button>
        <div id="mobileSearchOverlay"
            class="hidden fixed top-0 left-0 right-0 bg-black px-5 py-3 items-center z-50 transition-transform duration-300 transform -translate-y-full">
            <div class="flex items-center w-full border-2 border-neutral-900 rounded-full px-4 py-2 bg-black">
                <input type="text" id="mobileSearchInput"
                    placeholder="Search <?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?> or paste your code..."
                    class="flex-1 text-[1rem] text-gray-200 bg-transparent border-none outline-none tracking-wide placeholder:text-gray-400 placeholder:font-light text-sm placeholder:tracking-normal truncate">
            </div>
        </div>
        <button class="hidden max-[750px]:inline-flex items-center justify-center -ml-2 relative left-7 cursor-pointer"
            id="moreOptionsBtn">
            <img src="./assets/images/icons/more-options-icon.svg" class="h-5 w-auto" alt="more-options-icon">
        </button>

        <div class="hidden absolute top-[1.4rem] left-[-4.2rem] bg-black text-gray-200 rounded-xl shadow-2xl shadow-black/40 w-36 py-2 z-50 opacity-0 transform scale-95 transition-all duration-200 ease-out"
            id="moreOptionsMenu">
            <button
                class="flex items-center w-full px-4 py-2 text-base font-light text-gray-200 no-underline cursor-pointer hover:bg-[#332631] hover:rounded-lg max-[56.25rem]:text-sm"><img
                    src="./assets/images/icons/upload.svg" class="h-5 mr-2" alt="upload-icon">
                <span>Uploads</span>
            </button>
            <button
                class="flex items-center w-full px-4 py-2 text-base font-light text-gray-200 no-underline cursor-pointer hover:bg-[#332631] hover:rounded-lg max-[56.25rem]:text-sm">
                <img src="./assets/images/icons/reminders.svg" class="h-5 mr-2" alt="reminders-icon">
                <span>Reminders</span>
            </button>
            <button
                class="flex items-center w-full px-4 py-2 text-base font-light text-gray-200 no-underline cursor-pointer hover:bg-[#332631] hover:rounded-lg max-[56.25rem]:text-sm">
                <img src="./assets/images/icons/settings.svg" class="h-5 mr-2" alt="settings-icon">
                <span>Settings</span>
            </button>
            <button onclick="window.location.href='./core/auth/auth_check.php'"
                class="flex items-center w-full px-4 py-2 text-base font-light text-gray-200 no-underline cursor-pointer hover:bg-[#332631] hover:rounded-lg max-[56.25rem]:text-sm">
                <img src="./assets/images/icons/default-user.png" class="h-5 mr-2" alt="default-user-icon">
                <span>Account</span>
            </button>
        </div>

        <div class="flex items-center max-[750px]:hidden">
            <button class="ml-2 cursor-pointer"><img src="./assets/images/icons/upload.svg" class="h-5 w-auto"
                    alt="upload-icon"></button>
            <button class="ml-8 cursor-pointer"><img src="./assets/images/icons/reminders.svg" class="h-5 w-auto"
                    alt="reminders-icon"></button>
            <button class="ml-8 cursor-pointer"><img src="./assets/images/icons/settings.svg" class="h-5 w-auto"
                    alt="settings-icon"></button>
            <button onclick="window.location.href='./core/auth/auth_check.php'" class="ml-8 cursor-pointer"><img
                    src="./assets/images/icons/default-user.png" class="h-5 w-auto" alt="default-user-icon"></button>
        </div>
    </div>

</nav>