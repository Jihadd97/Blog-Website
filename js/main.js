const navItems = document.querySelector('.nav_items')
const openNavBtn = document.querySelector('#open_nav-btn')
const closeNavBtn = document.querySelector('#close_nav-btn')

//open nav dropdown
const openNav = () => {
    navItems.style.display = 'flex'
    openNavBtn.style.display = 'none'
    closeNavBtn.style.display = 'inline-block'
}

//close nav dropdown
const closeNav = () => {
    navItems.style.display = 'none'
    openNavBtn.style.display = 'inline-block'
    closeNavBtn.style.display = 'none'
}
openNavBtn.addEventListener('click', openNav)
closeNavBtn.addEventListener('click', closeNav)


const sideBar = document.querySelector('aside')
const showSidebarBtn = document.querySelector('#show_sidebar-btn')
const hideSidebarBtn = document.querySelector('#hide_sidebar-btn')

//shows sidebar on samll devices
const showSidebar = () => {
    sideBar.style.left = '0'
    showSidebarBtn.style.display = 'none'
    hideSidebarBtn.style.display = 'inline-block'
}
//hides sidebar on small devices

const hideSidebar = () => {
    sideBar.style.left = '-100%'
    hideSidebarBtn.style.display = 'none'
    showSidebarBtn.style.display = 'inline-block'
}

showSidebarBtn.addEventListener('click', showSidebar)
hideSidebarBtn.addEventListener('click', hideSidebar)
