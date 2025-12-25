<div
  class="sidebar group fixed top-[3.6rem] left-0 z-[9999] h-[calc(100vh-3.6rem)] w-[14.375rem] overflow-y-auto overflow-x-hidden bg-black pb-[25%] pr-[0.9375rem] pl-[0.9375rem] pt-[0.3125rem] group-[.small-sidebar]:w-[4.375rem] group-[.small-sidebar]:overflow-y-hidden max-[31.25rem]:group-[.small-sidebar]:hidden">

  <div class="shortcut-links">
    <button id="home-btn"
      class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.526rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
      <img src="./assets/images/icons/home-icon.svg"
        class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
        data-hover="./assets/images/icons/home-fill-icon.svg">
      <p
        class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
        Home</p>
    </button>
    <button id="trending-btn"
      class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
      <img src="./assets/images/icons/trending-icon.svg"
        class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
        data-hover="./assets/images/icons/trending-fill-icon.svg">
      <p
        class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
        Trending</p>
    </button>
    <hr
      class="sidebar-hr my-[0.3125rem] ml-[1%] h-[0.0625rem] w-[99%] border-0 bg-neutral-700 transition-width duration-300 ease-in-out group-[.small-sidebar]:w-full max-[56.25rem]:w-[99%]">
  </div>

  <div class="shortcut-links">
    <button id="watched-btn"
      class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
      <img src="./assets/images/icons/watched-icon.svg"
        class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
        data-hover="./assets/images/icons/watched-fill-icon.svg">
      <p
        class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
        Watched</p>
    </button>
    <button id="favourites-btn"
      class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
      <img src="./assets/images/icons/favourites-icon.svg"
        class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
        data-hover="./assets/images/icons/favourites-fill-icon.svg">
      <p
        class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
        Favourites</p>
    </button>
    <button id="followings-btn"
      class="icon-btn categories-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
      <img src="./assets/images/icons/followings-icon.svg"
        class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
        data-hover="./assets/images/icons/followings-fill-icon.svg">
      <p
        class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
        Followings</p>
      <div
        class="right-side absolute right-0 mr-[0.375rem] flex items-center bg-transparent ml-auto group-[.small-sidebar]:hidden">
        <div class="divider mx-[0.625rem] h-[1.3rem] w-[0.0625rem] bg-neutral-700"></div>
        <img src="./assets/images/icons/arrow-down.svg" class="arrow-icon h-[1.3rem] w-auto">
      </div>
    </button>
    <div class="dropdown hidden flex-col">
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 active:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/users/apple.jpg"
          class="icon block h-[1.5rem] w-[1.5rem] rounded-full object-cover max-[56.25rem]:h-[1.3rem] max-[56.25rem]:w-[1.3rem]">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          @apple</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 active:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/users/cumatozz.jpg"
          class="icon block h-[1.5rem] w-[1.5rem] rounded-full object-cover max-[56.25rem]:h-[1.3rem] max-[56.25rem]:w-[1.3rem]">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          @cumatozz</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 active:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/users/johnny-sins.jpg"
          class="icon block h-[1.5rem] w-[1.5rem] rounded-full object-cover max-[56.25rem]:h-[1.3rem] max-[56.25rem]:w-[1.3rem]">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          @johnny_sins</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 active:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/users/sweetie-fox.jpg"
          class="icon block h-[1.5rem] w-[1.5rem] rounded-full object-cover max-[56.25rem]:h-[1.3rem] max-[56.25rem]:w-[1.3rem]">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          @sweetie_fox</p>
      </button>
    </div>
    <hr
      class="sidebar-hr my-[0.3125rem] ml-[1%] h-[0.0625rem] w-[99%] border-0 bg-neutral-700 transition-width duration-300 ease-in-out group-[.small-sidebar]:w-full max-[56.25rem]:w-[99%]">
  </div>

  <div class="shortcut-links">
    <button id="categories-btn"
      class="icon-btn categories-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
      <img src="./assets/images/icons/categories-icon.svg"
        class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
        data-hover="./assets/images/icons/categories-fill-icon.svg" alt="Categories icon">
      <p
        class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
        Categories</p>
      <div
        class="right-side absolute right-0 mr-[0.375rem] flex items-center bg-transparent ml-auto group-[.small-sidebar]:hidden">
        <div class="divider mx-[0.625rem] h-[1.3rem] w-[0.0625rem] bg-neutral-700"></div>
        <img src="./assets/images/icons/arrow-down.svg" class="arrow-icon h-[1.3rem] w-auto">
      </div>
    </button>
    <div class="dropdown hidden flex-col">
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/straight-gender-icon.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/straight-gender-fill-icon.svg" alt="Male icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Straight</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/gay-gender-icon.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/gay-gender-fill-icon.svg" alt="Male icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Gay</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/trans-gender-icon.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/trans-gender-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Trans</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/lesbian-gender-icon.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/lesbian-gender-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Lesbian</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/bisexual-gender-icon.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/bisexual-gender-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Bisexual</p>
      </button>
    </div>
    <button id="fan-picks-btn"
      class="icon-btn categories-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
      <img src="./assets/images/icons/fan-pick's-icon.svg"
        class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
        data-hover="./assets/images/icons/fan-pick's-fill-icon.svg" alt="Fan Pick's icon">
      <p
        class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
        Fan Picks’</p>
      <div
        class="right-side absolute right-0 mr-[0.375rem] flex items-center bg-transparent ml-auto group-[.small-sidebar]:hidden">
        <div class="divider mx-[0.625rem] h-[1.3rem] w-[0.0625rem] bg-neutral-700"></div>
        <img src="./assets/images/icons/arrow-down.svg" class="arrow-icon h-[1.3rem] w-auto">
      </div>
    </button>
    <div class="dropdown fan-picks-dropdown hidden flex-col group-[.small-sidebar]:!hidden">
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/fan-pick's-sub-con.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/fan-pick's-sub-fill-icon.svg" alt="Male icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Teen (18+)</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/fan-pick's-sub-con.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/fan-pick's-sub-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          MILF</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/fan-pick's-sub-con.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/fan-pick's-sub-fill-icon.svg" alt="Male icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Anal</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/fan-pick's-sub-con.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/fan-pick's-sub-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Hardcore BDSM</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/fan-pick's-sub-con.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/fan-pick's-sub-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Threesome</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/fan-pick's-sub-con.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/fan-pick's-sub-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Hentai</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/fan-pick's-sub-con.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/fan-pick's-sub-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          JAV</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/fan-pick's-sub-con.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/fan-pick's-sub-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Russian</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/fan-pick's-sub-con.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/fan-pick's-sub-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Korean</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/fan-pick's-sub-con.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/fan-pick's-sub-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Chinese</p>
      </button>
      <button
        class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
        <img src="./assets/images/icons/fan-pick's-sub-con.svg"
          class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
          data-hover="./assets/images/icons/fan-pick's-sub-fill-icon.svg" alt="Female icon">
        <p
          class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
          Indian</p>
      </button>
    </div>
    <hr
      class="sidebar-hr my-[0.3125rem] ml-[1%] h-[0.0625rem] w-[99%] border-0 bg-neutral-700 transition-width duration-300 ease-in-out group-[.small-sidebar]:w-full max-[56.25rem]:w-[99%]">
  </div>

  <div class="shortcut-links">
    <p
      class="sidebar-title my-1 ml-[0.625rem] whitespace-nowrap text-gray-200 text-base max-[56.25rem]:text-sm group-[.small-sidebar]:hidden">
      More from <?php echo htmlspecialchars(!empty($_ENV['DOMAIN']) ? $_ENV['DOMAIN'] : 'UNKNOWN DOMAIN'); ?></p>
    <button id="the-originals-btn"
      class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
      <img src="./assets/images/icons/the-st-originals-icon.svg"
        class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
        data-hover="./assets/images/icons/the-st-originals-fill-icon.svg">
      <p
        class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
        The ST Originals</p>
    </button>
    <button id="trust-support-btn"
      class="icon-btn relative flex w-full cursor-pointer items-center justify-start gap-[0.9375rem] border-none bg-transparent py-[0.525rem] pr-[0.25rem] pl-[0.75rem] text-base font-light text-gray-200 no-underline hover:rounded-[0.625rem] hover:bg-neutral-900 [&.active]:rounded-[0.625rem] [&.active]:bg-neutral-900 group-[.small-sidebar]:w-full group-[.small-sidebar]:justify-center group-[.small-sidebar]:p-[0.75rem] max-[56.25rem]: max-[56.25rem]:text-sm">
      <img src="./assets/images/icons/trust-icon.svg"
        class="icon block h-[1.3rem] w-auto bg-transparent max-[56.25rem]:h-[1.125rem]"
        data-hover="./assets/images/icons/trust-fill-icon.svg">
      <p
        class="label m-0 block min-w-0 max-w-full overflow-hidden text-ellipsis whitespace-nowrap bg-transparent group-[.small-sidebar]:hidden">
        Trust & Support</p>
    </button>
  </div>
</div>