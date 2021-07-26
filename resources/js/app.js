'use strict';

const moment = require('moment-timezone');
const axios = require('axios');
const Autocomplete = require("@trevoreyre/autocomplete-js").default;
const pwaName = "Appkit";

function index(el) {
    if (!el) return -1;
    var i = 0;
    do {
        i++;
    } while (el = el.previousElementSibling);
    return i;
}

class api {
    request(url, data) {
        const {token} = this,
            config = {
                headers: {
                    Authorization: `Bearer ${token}`,
                }
            };

        return axios.post(url, data, config);
    }

    setToken(token) {
        this.token = token;

        return this
    }

    places(input) {
        return new Promise(resolve => {
            if (input.length < 3) {
                return resolve([])
            }

            return this.request(`https://api.sportm4te.com/v1.0/places?q=${encodeURI(input)}`)
                .then(response => {
                    resolve(response.data)
                })
        })
    }

    me() {
        return this.request('https://api.sportm4te.com/v1.0/me');
    }
}

class hooks {
    constructor() {
        this.hooks = {};

        this.register('basic-response-redirect', (data) => {
            _sportM4te.toast({
                icon: 'fa fa-check',
                ...data
            });

            setTimeout(() => {
                window.location = data.event.link;
            }, 1200);
        });

        this.register('basic-response-reload', (data) => {
            _sportM4te.toast({
                icon: 'fa fa-check',
                ...data
            });

            setTimeout(() => {
                window.location.reload();
            }, 1200);
        });

        this.register('event-removed', (data) => {
            _sportM4te.toast({
                icon: 'fa fa-check',
                ...data
            });

            setTimeout(() => {
                window.location = '/events/me';
            }, 1200);
        });

        this.register('basic-response', (data) => {
            _sportM4te.toast({
                icon: 'fa fa-check',
                ...data
            });
        });

        this.register('join-request-update', (data, form) => {
            form.parentNode.removeChild(form);
        });

        this.register('friend-request-respond', (data, form) => {
            if (location.pathname === '/home') {
                form.parentNode.removeChild(form);
            } else {
                setTimeout(() => {
                    window.location.reload();
                }, 1200);
            }
        });
    }

    trigger(hook, args) {
        if (this.hooks[hook]) {
            return this.hooks[hook](...args);
        }
    }

    register(hook, callback) {
        this.hooks[hook] = callback;
    }
}

class sportM4te {
    async init(token) {
        const {forms} = document;

        this.api = new api;
        this.hooks = new hooks;
        this.api.setToken(token);

        const shareCheck = document.querySelectorAll('.shareToFacebook, .shareToTwitter, .shareToLinkedIn');
        if (shareCheck.length) {
            const share_link = window.location.href;
            const share_title = document.title;
            document.querySelectorAll('.shareToFacebook').forEach(x => x.setAttribute("href", "https://www.facebook.com/sharer/sharer.php?u=" + share_link));
            document.querySelectorAll('.shareToTwitter').forEach(x => x.setAttribute("href", "https://twitter.com/share?text=" + share_link));
            document.querySelectorAll('.shareToPinterest').forEach(x => x.setAttribute("href", "https://pinterest.com/pin/create/button/?url=" + share_link));
            document.querySelectorAll('.shareToWhatsApp').forEach(x => x.setAttribute("href", "whatsapp://send?text=" + share_link));
            document.querySelectorAll('.shareToMail').forEach(x => x.setAttribute("href", "mailto:?body=" + share_link));
            document.querySelectorAll('.shareToLinkedIn').forEach(x => x.setAttribute("href", "https://www.linkedin.com/shareArticle?mini=true&url=" + share_link + "&title=" + share_title + "&summary=&source="));
        }

        const menus = document.querySelectorAll('.menu');
        if (menus.length) {
            const menuHider = document.getElementsByClassName('menu-hider');
            if (!menuHider.length) {
                document.body.innerHTML += '<div class="menu-hider"></div>';
            }
            if (menuHider[0].classList.contains('menu-active')) {
                menuHider[0].classList.remove('menu-active');
            }

            const menuSidebar = document.querySelectorAll('.menu-box-left, .menu-box-right');
            menuSidebar.forEach(function (e) {
                if (e.getAttribute('data-menu-width') === "cover") {
                    e.style.width = '100%'
                } else {
                    e.style.width = (e.getAttribute('data-menu-width')) + 'px'
                }
            })
            const menuSheets = document.querySelectorAll('.menu-box-bottom, .menu-box-top, .menu-box-modal');
            menuSheets.forEach(function (e) {
                if (e.getAttribute('data-menu-width') === "cover") {
                    e.style.width = '100%'
                    e.style.height = '100%'
                } else {
                    e.style.width = (e.getAttribute('data-menu-width')) + 'px'
                    e.style.height = (e.getAttribute('data-menu-height')) + 'px'
                }
            })
        }

        this.checkDarkMode();

        if(localStorage.getItem(pwaName+'-Theme') === "dark-mode"){document.body.className = 'theme-dark';}
        if(localStorage.getItem(pwaName+'-Theme') === "light-mode"){document.body.className = 'theme-light';}

        Array.from(forms).forEach((form) => {
            const hook = form.getAttribute('data-hook');

            if (hook === 'none') {
                return;
            }

            form.addEventListener('submit', (event) => {
                event.preventDefault();

                const data = new FormData(form);
                const submitter = event.submitter || form.querySelector('button');

                if (submitter) {
                    data.append(submitter.name, submitter.value);
                }

                this.api.request(form.getAttribute('action'), data).then((response) => {
                    if (hook) {
                        this.hooks.trigger(hook, [response.data, form]);
                    } else {
                        this.toast({...response.data});
                    }
                }).catch(({response}) => {
                    if (response.data.error) {
                        this.toast({...response.data});
                    } else {
                        this.modalIcon('error');
                    }
                });

                return false;
            });
        });
    }

    places(selector, onSubmit, debounceTime = 300) {
        const element = document.querySelector(selector);
        new Autocomplete(element, {
            search: input => {
                return this.api.places(input)
            },
            debounceTime,
            getResultValue: result => result.location,
            onSubmit: result => {
                document.querySelector('[name=place_id]').value = result.id;

                if (typeof onSubmit === 'function') {
                    onSubmit.call(element, result);
                }
            }
        })
    }

    toast({message, error, title, icon, redirect}) {
        let element = document.getElementById('basic-snackbar'),
            className = 'bg-green-dark';

        if (error) {
            message = error.message;
            title = 'Error';
            icon = 'fa fa-times';
            className = 'bg-red-dark';
        }

        if (icon) {
            if (title) {
                title = `<i class="fa ${icon} me-3"></i>` + title;
            } else if (message) {
                message = `<i class="fa ${icon} me-3"></i>` + message;
            }
        }

        if (title) {
            element.innerHTML = `<h1 class="color-white font-20 pt-3 pb-3 mb-n4">${title}</h1><p class="color-white mb-0 pb-1">${message}</p>`;
        } else {
            element.innerHTML = message;
        }

        element.setAttribute('class', `snackbar-toast color-white ` + className);

        if (redirect) {
            setTimeout(() => {
                window.location = redirect;
            }, 2500);
        }

        const notificationToast = new bootstrap.Toast(element);
        notificationToast.show();
    }

    modalIcon(menuData) {
        const activeMenu = document.querySelectorAll('.menu-active');
        for (let i = 0; i < activeMenu.length; i++) {
            activeMenu[i].classList.remove('menu-active');
        }
        document.getElementById(menuData).classList.add('menu-active');
        document.getElementsByClassName('menu-hider')[0].classList.add('menu-active');
        //Check and Apply Effects
        var menu = document.getElementById(menuData);
        var menuEffect = menu.getAttribute('data-menu-effect');
        var menuLeft = menu.classList.contains('menu-box-left');
        var menuRight = menu.classList.contains('menu-box-right');
        var menuTop = menu.classList.contains('menu-box-top');
        var menuBottom = menu.classList.contains('menu-box-bottom');
        let menuWidth = menu.offsetWidth;
        const menuHeight = menu.offsetHeight;
        const menuTimeout = menu.getAttribute('data-menu-hide');

        if (menuTimeout) {
            setTimeout(function () {
                document.getElementById(menuData).classList.remove('menu-active');
                document.getElementsByClassName('menu-hider')[0].classList.remove('menu-active');
            }, menuTimeout)
        }

        if (menuEffect === "menu-push") {
            menuWidth = document.getElementById(menuData).getAttribute('data-menu-width');
            if (menuLeft) {
                for (let i = 0; i < wrappers.length; i++) {
                    wrappers[i].style.transform = "translateX(" + menuWidth + "px)"
                }
            }
            if (menuRight) {
                for (let i = 0; i < wrappers.length; i++) {
                    wrappers[i].style.transform = "translateX(-" + menuWidth + "px)"
                }
            }
            if (menuBottom) {
                for (let i = 0; i < wrappers.length; i++) {
                    wrappers[i].style.transform = "translateY(-" + menuHeight + "px)"
                }
            }
            if (menuTop) {
                for (let i = 0; i < wrappers.length; i++) {
                    wrappers[i].style.transform = "translateY(" + menuHeight + "px)"
                }
            }
        }
        if (menuEffect === "menu-parallax") {
            menuWidth = document.getElementById(menuData).getAttribute('data-menu-width');
            if (menuLeft) {
                for (let i = 0; i < wrappers.length; i++) {
                    wrappers[i].style.transform = "translateX(" + menuWidth / 10 + "px)"
                }
            }
            if (menuRight) {
                for (let i = 0; i < wrappers.length; i++) {
                    wrappers[i].style.transform = "translateX(-" + menuWidth / 10 + "px)"
                }
            }
            if (menuBottom) {
                for (let i = 0; i < wrappers.length; i++) {
                    wrappers[i].style.transform = "translateY(-" + menuHeight / 5 + "px)"
                }
            }
            if (menuTop) {
                for (let i = 0; i < wrappers.length; i++) {
                    wrappers[i].style.transform = "translateY(" + menuHeight / 5 + "px)"
                }
            }
        }
    }
    checkDarkMode(){
        const toggleDark = document.querySelectorAll('[data-toggle-theme]');
        function activateDarkMode(){
            document.body.classList.add('theme-dark');
            document.body.classList.remove('theme-light', 'detect-theme');
            for(let i = 0; i < toggleDark.length; i++){toggleDark[i].checked="checked"};
            localStorage.setItem(pwaName+'-Theme', 'dark-mode');
        }
        function activateLightMode(){
            document.body.classList.add('theme-light');
            document.body.classList.remove('theme-dark','detect-theme');
            for(let i = 0; i < toggleDark.length; i++){toggleDark[i].checked=false};
            localStorage.setItem(pwaName+'-Theme', 'light-mode');
        }
        function removeTransitions(){var falseTransitions = document.querySelectorAll('.btn, .header, #footer-bar, .menu-box, .menu-active'); for(let i = 0; i < falseTransitions.length; i++) {falseTransitions[i].style.transition = "all 0s ease";}}
        function addTransitions(){var trueTransitions = document.querySelectorAll('.btn, .header, #footer-bar, .menu-box, .menu-active'); for(let i = 0; i < trueTransitions.length; i++) {trueTransitions[i].style.transition = "";}}

        function setColorScheme() {
            const isDarkMode = window.matchMedia("(prefers-color-scheme: dark)").matches
            const isLightMode = window.matchMedia("(prefers-color-scheme: light)").matches
            const isNoPreference = window.matchMedia("(prefers-color-scheme: no-preference)").matches
            window.matchMedia("(prefers-color-scheme: dark)").addListener(e => e.matches && activateDarkMode())
            window.matchMedia("(prefers-color-scheme: light)").addListener(e => e.matches && activateLightMode())
            if(isDarkMode) activateDarkMode();
            if(isLightMode) activateLightMode();
        }

        //Activating Dark Mode
        var darkModeSwitch = document.querySelectorAll('[data-toggle-theme]')
        darkModeSwitch.forEach(el => el.addEventListener('click',e =>{
            if(document.body.classList.contains("theme-light")){ removeTransitions(); activateDarkMode();}
            else if(document.body.classList.contains("theme-dark")){ removeTransitions(); activateLightMode();}
            setTimeout(function(){addTransitions();},350);
        }));

        //Set Color Based on Remembered Preference.
        if(localStorage.getItem(pwaName+'-Theme') == "dark-mode"){for(let i = 0; i < toggleDark.length; i++){toggleDark[i].checked="checked"};document.body.classList.add('theme-dark');}
        if(localStorage.getItem(pwaName+'-Theme') == "light-mode"){document.body.classList.add('theme-light');} if(document.body.classList.contains("detect-theme")){setColorScheme();}

        //Detect Dark/Light Mode
        const darkModeDetect = document.querySelectorAll('.detect-dark-mode');
        darkModeDetect.forEach(el => el.addEventListener('click',e =>{
            document.body.classList.remove('theme-light', 'theme-dark');
            document.body.classList.add('detect-theme')
            setTimeout(function(){setColorScheme();},50)
        }))
    }

    review() {
        const stars = document.querySelectorAll('#user-review .fa-star'),
            rating = document.getElementById('rating'),
            button = document.querySelector('#user-review button');

        stars.forEach((element) => {
            element.addEventListener('click', (event) => {
                const i = index(event.target);

                stars.forEach((star, index) => {
                    if (index < i) {
                        star.classList.add('color-yellow-dark');
                        star.classList.remove('color-dark-dark');
                    } else {
                        star.classList.add('color-dark-dark');
                        star.classList.remove('color-yellow-dark');
                    }
                });

                rating.value = i;
                button.disabled = false;
            });
        });
    }

    stackedCards () {

        var stackedOptions = 'Top'; //Change stacked cards view from 'Bottom', 'Top' or 'None'.
        var rotate = true; //Activate the elements' rotation for each move on stacked cards.
        var items = 3; //Number of visible elements when the stacked options are bottom or top.
        var elementsMargin = 10; //Define the distance of each element when the stacked options are bottom or top.
        var useOverlays = true; //Enable or disable the overlays for swipe elements.
        var maxElements; //Total of stacked cards on DOM.
        var currentPosition = 0; //Keep the position of active stacked card.
        var velocity = 0.3; //Minimum velocity allowed to trigger a swipe.
        var rightObj; //Keep the swipe right properties.
        var leftObj; //Keep the swipe left properties.
        var listElNodesObj; //Keep the list of nodes from stacked cards.
        var listElNodesWidth; //Keep the stacked cards width.
        var currentElementObj; //Keep the stacked card element to swipe.
        var stackedCardsObj;
        var isFirstTime = true;
        var elementHeight;
        var obj;
        var elTrans;

        obj = document.getElementById('stacked-cards-block');
        stackedCardsObj = obj.querySelector('.stackedcards-container');
        listElNodesObj = stackedCardsObj.children;

        rightObj = obj.querySelector('.stackedcards-overlay.right');
        leftObj = obj.querySelector('.stackedcards-overlay.left');

        countElements();
        currentElement();
        changeBackground();
        listElNodesWidth = stackedCardsObj.offsetWidth;
        currentElementObj = listElNodesObj[0];
        updateUi();

        //Prepare elements on DOM
        let addMargin = elementsMargin * (items -1) + 'px';

        if(stackedOptions === "Top"){

            for(var i = items; i < maxElements; i++){
                listElNodesObj[i].classList.add('stackedcards-top', 'stackedcards--animatable', 'stackedcards-origin-top');
            }

            elTrans = elementsMargin * (items - 1);

            stackedCardsObj.style.marginBottom = addMargin;

        } else if(stackedOptions === "Bottom"){


            for(var i = items; i < maxElements; i++){
                listElNodesObj[i].classList.add('stackedcards-bottom', 'stackedcards--animatable', 'stackedcards-origin-bottom');
            }

            elTrans = 0;

            stackedCardsObj.style.marginBottom = addMargin;

        } else if (stackedOptions === "None"){

            for(var i = items; i < maxElements; i++){
                listElNodesObj[i].classList.add('stackedcards-none', 'stackedcards--animatable');
            }

            elTrans = 0;

        }

        for(var i = items; i < maxElements; i++){
            listElNodesObj[i].style.zIndex = 0;
            listElNodesObj[i].style.opacity = 0;
            listElNodesObj[i].style.webkitTransform ='scale(' + (1 - (items * 0.04)) +') translateX(0) translateY(' + elTrans + 'px) translateZ(0)';
            listElNodesObj[i].style.transform ='scale(' + (1 - (items * 0.04)) +') translateX(0) translateY(' + elTrans + 'px) translateZ(0)';
        }

        if(listElNodesObj[currentPosition]){
            listElNodesObj[currentPosition].classList.add('stackedcards-active');
        }

        if(useOverlays){
            leftObj.style.transform = 'translateX(0px) translateY(' + elTrans + 'px) translateZ(0px) rotate(0deg)';
            leftObj.style.webkitTransform = 'translateX(0px) translateY(' + elTrans + 'px) translateZ(0px) rotate(0deg)';

            rightObj.style.transform = 'translateX(0px) translateY(' + elTrans + 'px) translateZ(0px) rotate(0deg)';
            rightObj.style.webkitTransform = 'translateX(0px) translateY(' + elTrans + 'px) translateZ(0px) rotate(0deg)';

        } else {
            leftObj.className = '';
            rightObj.className = '';

            leftObj.classList.add('stackedcards-overlay-hidden');
            rightObj.classList.add('stackedcards-overlay-hidden');
        }

        //Remove class init
        setTimeout(function() {
            obj.classList.remove('init');
        },150);


        function backToMiddle() {

            removeNoTransition();
            transformUi(0, 0, 1, currentElementObj);

            if(useOverlays){
                transformUi(0, 0, 0, leftObj);
                transformUi(0, 0, 0, rightObj);
            }

            setZindex(5);

            if(!(currentPosition >= maxElements)){
                //roll back the opacity of second element
                if((currentPosition + 1) < maxElements){
                    listElNodesObj[currentPosition + 1].style.opacity = '.8';
                }
            }
        };

        // Usable functions
        function countElements() {
            maxElements = listElNodesObj.length;
            if(items > maxElements){
                items = maxElements;
            }
        };

        //Keep the active card.
        function currentElement() {
            currentElementObj = listElNodesObj[currentPosition];
        };

        //Change background for each swipe.
        function changeBackground() {
            document.body.classList.add("background-" + currentPosition + "");
        };

        //Change states
        function changeStages() {
            if(currentPosition == maxElements){
                //Event listener created to know when transition ends and changes states
                listElNodesObj[maxElements - 1].addEventListener('transitionend', function(){
                    document.querySelector('.stackedcards-container').classList.add('disabled');
                    document.querySelector('.final-state').classList.remove('disabled');
                    listElNodesObj[maxElements - 1].removeEventListener('transitionend', null, false);
                });
            }
        };

        //Functions to swipe left elements on logic external action.
        function onActionLeft() {
            if(!(currentPosition >= maxElements)){
                if(useOverlays) {
                    leftObj.classList.remove('no-transition');
                    leftObj.style.zIndex = '8';
                    transformUi(0, 0, 1, leftObj);

                }

                setTimeout(function() {
                    onSwipeLeft();
                    resetOverlayLeft();
                },300);
            }
        };

        //Functions to swipe right elements on logic external action.
        function onActionRight() {
            if(!(currentPosition >= maxElements)){
                if(useOverlays) {
                    rightObj.classList.remove('no-transition');
                    rightObj.style.zIndex = '8';
                    transformUi(0, 0, 1, rightObj);
                }

                setTimeout(function(){
                    onSwipeRight();
                    resetOverlayRight();
                },300);
            }
        };

        //Swipe active card to left.
        function onSwipeLeft() {
            removeNoTransition();
            transformUi(-1000, 0, 0, currentElementObj);
            if(useOverlays){
                transformUi(-1000, 0, 0, leftObj); //Move leftOverlay
                resetOverlayLeft();
            }
            currentPosition = currentPosition + 1;
            updateUi();
            currentElement();
            changeBackground();
            changeStages();
            setActiveHidden();
        };

        //Swipe active card to right.
        function onSwipeRight() {
            removeNoTransition();
            transformUi(1000, 0, 0, currentElementObj);
            if(useOverlays){
                transformUi(1000, 0, 0, rightObj); //Move rightOverlay
                resetOverlayRight();
            }

            const id = currentElementObj.getAttribute('data-id');

            _sportM4te.api.request('https://api.sportm4te.com/v1.0/events/request/hide', {
                id,
            });

            currentPosition = currentPosition + 1;
            updateUi();
            currentElement();
            changeBackground();
            changeStages();
            setActiveHidden();
        };

        //Swipe active card to top.
        function onSwipeTop() {
            return backToMiddle();
            removeNoTransition();
            transformUi(0, -1000, 0, currentElementObj);
            if(useOverlays){
                transformUi(0, -1000, 0, leftObj); //Move leftOverlay
                transformUi(0, -1000, 0, rightObj); //Move rightOverlay
                resetOverlays();
            }

            currentPosition = currentPosition + 1;
            updateUi();
            currentElement();
            changeBackground();
            changeStages();
            setActiveHidden();
        };

        //Remove transitions from all elements to be moved in each swipe movement to improve perfomance of stacked cards.
        function removeNoTransition() {
            if(listElNodesObj[currentPosition]){

                if(useOverlays) {
                    leftObj.classList.remove('no-transition');
                    rightObj.classList.remove('no-transition');
                }

                listElNodesObj[currentPosition].classList.remove('no-transition');
                listElNodesObj[currentPosition].style.zIndex = 6;
            }

        };

        //Move the overlay left to initial position.
        function resetOverlayLeft() {
            if(!(currentPosition >= maxElements)){
                if(useOverlays){
                    setTimeout(function(){

                        if(stackedOptions === "Top"){

                            elTrans = elementsMargin * (items - 1);

                        } else if(stackedOptions === "Bottom" || stackedOptions === "None"){

                            elTrans = 0;

                        }

                        if(!isFirstTime){

                            leftObj.classList.add('no-transition');

                        }

                        requestAnimationFrame(function(){

                            leftObj.style.transform = "translateX(0) translateY(" + elTrans + "px) translateZ(0)";
                            leftObj.style.webkitTransform = "translateX(0) translateY(" + elTrans + "px) translateZ(0)";
                            leftObj.style.opacity = '0';
                        });

                    },300);

                    isFirstTime = false;
                }
            }
        };

        //Move the overlay right to initial position.
        function resetOverlayRight() {
            if(!(currentPosition >= maxElements)){
                if(useOverlays){
                    setTimeout(function(){

                        if(stackedOptions === "Top"){

                            elTrans = elementsMargin * (items - 1);

                        } else if(stackedOptions === "Bottom" || stackedOptions === "None"){

                            elTrans = 0;

                        }

                        if(!isFirstTime){

                            rightObj.classList.add('no-transition');

                        }

                        requestAnimationFrame(function(){

                            rightObj.style.transform = "translateX(0) translateY(" + elTrans + "px) translateZ(0)";
                            rightObj.style.webkitTransform = "translateX(0) translateY(" + elTrans + "px) translateZ(0)";
                            rightObj.style.opacity = '0';

                        });

                    },300);

                    isFirstTime = false;
                }
            }
        };

        //Move the overlays to initial position.
        function resetOverlays() {
            if(!(currentPosition >= maxElements)){
                if(useOverlays){

                    setTimeout(function(){
                        if(stackedOptions === "Top"){

                            elTrans = elementsMargin * (items - 1);

                        } else if(stackedOptions === "Bottom" || stackedOptions === "None"){

                            elTrans = 0;

                        }

                        if(!isFirstTime){

                            leftObj.classList.add('no-transition');
                            rightObj.classList.add('no-transition');

                        }

                        requestAnimationFrame(function(){

                            leftObj.style.transform = "translateX(0) translateY(" + elTrans + "px) translateZ(0)";
                            leftObj.style.webkitTransform = "translateX(0) translateY(" + elTrans + "px) translateZ(0)";
                            leftObj.style.opacity = '0';

                            rightObj.style.transform = "translateX(0) translateY(" + elTrans + "px) translateZ(0)";
                            rightObj.style.webkitTransform = "translateX(0) translateY(" + elTrans + "px) translateZ(0)";
                            rightObj.style.opacity = '0';


                        });

                    },300);	// wait for animations time

                    isFirstTime = false;
                }
            }
        };

        function setActiveHidden() {
            if(!(currentPosition >= maxElements)){
                listElNodesObj[currentPosition - 1].classList.remove('stackedcards-active');
                listElNodesObj[currentPosition - 1].classList.add('stackedcards-hidden');
                listElNodesObj[currentPosition].classList.add('stackedcards-active');
            }
        };

        //Set the new z-index for specific card.
        function setZindex(zIndex) {
            if(listElNodesObj[currentPosition]){
                listElNodesObj[currentPosition].style.zIndex = zIndex;
            }
        };

        // Remove element from the DOM after swipe. To use this method you need to call this function in onSwipeLeft, onSwipeRight and onSwipeTop and put the method just above the variable 'currentPosition = currentPosition + 1'.
        //On the actions onSwipeLeft, onSwipeRight and onSwipeTop you need to remove the currentPosition variable (currentPosition = currentPosition + 1) and the function setActiveHidden

        function removeElement() {
            currentElementObj.remove();
            if(!(currentPosition >= maxElements)){
                listElNodesObj[currentPosition].classList.add('stackedcards-active');
            }
        };

        //Add translate X and Y to active card for each frame.
        function transformUi(moveX,moveY,opacity,elementObj) {
            requestAnimationFrame(function(){
                var element = elementObj;

                // Function to generate rotate value
                function RotateRegulator(value) {
                    if(value/10 > 15) {
                        return 15;
                    }
                    else if(value/10 < -15) {
                        return -15;
                    }
                    return value/10;
                }

                let rotateElement;
                if(rotate){
                    rotateElement = RotateRegulator(moveX);
                } else {
                    rotateElement = 0;
                }

                if(stackedOptions === "Top"){
                    elTrans = elementsMargin * (items - 1);
                    if(element){
                        element.style.webkitTransform = "translateX(" + moveX + "px) translateY(" + (moveY + elTrans) + "px) translateZ(0) rotate(" + rotateElement + "deg)";
                        element.style.transform = "translateX(" + moveX + "px) translateY(" + (moveY + elTrans) + "px) translateZ(0) rotate(" + rotateElement + "deg)";
                        element.style.opacity = opacity;
                    }
                } else if(stackedOptions === "Bottom" || stackedOptions === "None"){

                    if(element){
                        element.style.webkitTransform = "translateX(" + moveX + "px) translateY(" + (moveY) + "px) translateZ(0) rotate(" + rotateElement + "deg)";
                        element.style.transform = "translateX(" + moveX + "px) translateY(" + (moveY) + "px) translateZ(0) rotate(" + rotateElement + "deg)";
                        element.style.opacity = opacity;
                    }

                }
            });
        };

        //Action to update all elements on the DOM for each stacked card.
        function updateUi() {
            requestAnimationFrame(function(){
                elTrans = 0;
                var elZindex = 5;
                var elScale = 1;
                var elOpac = 1;
                var elTransTop = items;
                var elTransInc = elementsMargin;

                for(var i = currentPosition; i < (currentPosition + items); i++){
                    if(listElNodesObj[i]){
                        if(stackedOptions === "Top"){

                            listElNodesObj[i].classList.add('stackedcards-top', 'stackedcards--animatable', 'stackedcards-origin-top');

                            if(useOverlays){
                                leftObj.classList.add('stackedcards-origin-top');
                                rightObj.classList.add('stackedcards-origin-top');
                            }

                            elTrans = elTransInc * elTransTop;
                            elTransTop--;

                        } else if(stackedOptions === "Bottom"){
                            listElNodesObj[i].classList.add('stackedcards-bottom', 'stackedcards--animatable', 'stackedcards-origin-bottom');

                            if(useOverlays){
                                leftObj.classList.add('stackedcards-origin-bottom');
                                rightObj.classList.add('stackedcards-origin-bottom');
                            }

                            elTrans = elTrans + elTransInc;

                        } else if (stackedOptions === "None"){

                            listElNodesObj[i].classList.add('stackedcards-none', 'stackedcards--animatable');
                            elTrans = elTrans + elTransInc;

                        }

                        listElNodesObj[i].style.transform ='scale(' + elScale + ') translateX(0) translateY(' + (elTrans - elTransInc) + 'px) translateZ(0)';
                        listElNodesObj[i].style.webkitTransform ='scale(' + elScale + ') translateX(0) translateY(' + (elTrans - elTransInc) + 'px) translateZ(0)';
                        listElNodesObj[i].style.opacity = elOpac;
                        listElNodesObj[i].style.zIndex = elZindex;

                        elScale = elScale - 0.04;
                        elOpac = elOpac - (1 / items);
                        elZindex--;
                    }
                }

            });

        };

        //Touch events block
        var element = obj;
        var startTime;
        var startX;
        var startY;
        var translateX;
        var translateY;
        var currentX;
        var currentY;
        var touchingElement = false;
        var timeTaken;
        var topOpacity;
        var rightOpacity;
        var leftOpacity;

        function setOverlayOpacity() {

            topOpacity = (((translateY + (elementHeight) / 2) / 100) * -1);
            rightOpacity = translateX / 100;
            leftOpacity = ((translateX / 100) * -1);


            if(topOpacity > 1) {
                topOpacity = 1;
            }

            if(rightOpacity > 1) {
                rightOpacity = 1;
            }

            if(leftOpacity > 1) {
                leftOpacity = 1;
            }
        }

        function gestureStart(evt) {
            startTime = new Date().getTime();

            startX = evt.changedTouches[0].clientX;
            startY = evt.changedTouches[0].clientY;

            currentX = startX;
            currentY = startY;

            setOverlayOpacity();

            touchingElement = true;
            if(!(currentPosition >= maxElements)){
                if(listElNodesObj[currentPosition]){
                    listElNodesObj[currentPosition].classList.add('no-transition');
                    setZindex(6);

                    if(useOverlays){
                        leftObj.classList.add('no-transition');
                        rightObj.classList.add('no-transition');
                    }

                    if((currentPosition + 1) < maxElements){
                        listElNodesObj[currentPosition + 1].style.opacity = '1';
                    }

                    elementHeight = listElNodesObj[currentPosition].offsetHeight / 3;
                }

            }

        };

        function gestureMove(evt) {
            currentX = evt.changedTouches[0].pageX;
            currentY = evt.changedTouches[0].pageY;

            translateX = currentX - startX;
            translateY = currentY - startY;

            setOverlayOpacity();

            if(!(currentPosition >= maxElements)){
                evt.preventDefault();
                transformUi(translateX, translateY, 1, currentElementObj);

                if(useOverlays){
                    if(translateX < 0){
                        transformUi(translateX, translateY, leftOpacity, leftObj);
                        transformUi(0, 0, 0, rightObj);

                    } else if(translateX > 0){
                        transformUi(translateX, translateY, rightOpacity, rightObj);
                        transformUi(0, 0, 0, leftObj);
                    }

                    if(useOverlays){
                        leftObj.style.zIndex = 8;
                        rightObj.style.zIndex = 8;
                    }

                }

            }

        };

        function gestureEnd(evt) {

            if(!touchingElement){
                return;
            }

            translateX = currentX - startX;
            translateY = currentY - startY;

            timeTaken = new Date().getTime() - startTime;

            touchingElement = false;

            if(!(currentPosition >= maxElements)){
                if(translateY < (elementHeight * -1) && translateX > ((listElNodesWidth / 2) * -1) && translateX < (listElNodesWidth / 2)){  //is Top?

                    if(translateY < (elementHeight * -1) || (Math.abs(translateY) / timeTaken > velocity)){ // Did It Move To Top?
                        onSwipeTop();
                    } else {
                        backToMiddle();
                    }

                } else {

                    if(translateX < 0){
                        if(translateX < ((listElNodesWidth / 2) * -1) || (Math.abs(translateX) / timeTaken > velocity)){ // Did It Move To Left?
                            onSwipeLeft();
                        } else {
                            backToMiddle();
                        }
                    } else if(translateX > 0) {

                        if (translateX > (listElNodesWidth / 2) && (Math.abs(translateX) / timeTaken > velocity)){ // Did It Move To Right?
                            onSwipeRight();
                        } else {
                            backToMiddle();
                        }

                    }
                }
            }
        };

        element.addEventListener('touchstart', gestureStart, false);
        element.addEventListener('touchmove', gestureMove, false);
        element.addEventListener('touchend', gestureEnd, false);
    }

    guessTimezone() {
        return moment.tz.guess();
    }
}

const _sportM4te = new sportM4te;
window.sportM4te = _sportM4te;
