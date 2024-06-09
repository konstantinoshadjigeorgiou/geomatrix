(function ($) {
  $(function () {
    $("#page a > img").each(function () {
      $(this).parent().addClass("no-underline");
    });

    $('a[href*="#"]').each(function () {
      $(this).on("click", function (e) {
        e.preventDefault();

        link = $(this).attr("href");
        if (link.length > 1) {
          el = $(link);
          if (el.length) {
            el[0].scrollIntoView({
              behavior: "smooth",
            });
          } else {
            window.location = $(this).attr("href");
          }
        }
      });
    });

    let faq = $(".faq");
    faq.on("click", function () {
      if ($(this).hasClass("faq--open")) {
        $(this).removeClass("faq--open");
      } else {
        faq.removeClass("faq--open");
        $(this).toggleClass("faq--open");
      }
    });

    $(".my-slick").slick({
      slidesToShow: 1,
      arrows: false,
      infinite: false,
      dots: true,
      mobileFirst: true,
      responsive: [
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 2,
          },
        },
        {
          breakpoint: 991,
          settings: "unslick",
        },
      ],
    });
  });
})(jQuery);

/**
 * Applying Styles Based On The User Scroll Position With Smart CSS
 */
// The debounce function receives our function as a parameter
const debounce = (fn) => {
  // This holds the requestAnimationFrame reference, so we can cancel it if we wish
  let frame;

  // The debounce function returns a new function that can receive a variable number of arguments
  return (...params) => {
    // If the frame variable has been defined, clear it now, and queue for next frame
    if (frame) {
      cancelAnimationFrame(frame);
    }

    // Queue our function call for the next frame
    frame = requestAnimationFrame(() => {
      // Call our function and pass any params we received
      fn(...params);
    });
  };
};

// Reads out the scroll position and stores it in the data attribute
// so we can use it in our stylesheets
const storeScroll = () => {
  document.documentElement.dataset.scroll = window.scrollY;
};

// Listen for new scroll events, here we debounce our `storeScroll` function
document.addEventListener("scroll", debounce(storeScroll), { passive: true });

// Update scroll position for first time
storeScroll();

/**
 * Wait for element to appear in the DOM
 * @param {string} selector
 */
function waitForElement(selector) {
  return new Promise((resolve) => {
    if (document.querySelector(selector)) {
      return resolve(document.querySelector(selector));
    }

    const observer = new MutationObserver((mutations) => {
      if (document.querySelector(selector)) {
        resolve(document.querySelector(selector));
        observer.disconnect();
      }
    });

    observer.observe(document.body, {
      childList: true,
      subtree: true,
    });
  });
}
