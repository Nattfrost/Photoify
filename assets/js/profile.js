console.log('profile')
const userPosts = JSON.parse(getCookie('userPosts'))
const container = document.querySelector('.posts-container')
console.log(container)
console.table(userPosts)


userPosts.forEach((post, i) => {
container.innerHTML += `<img src="${post.image}">`
})
