console.log('home')
const posts = JSON.parse(getCookie('posts'))
const container = document.querySelector('.posts-container')
console.log(container)
console.table(posts)


posts.forEach((post, i) => {
container.innerHTML += `<img src="${post.image}">`
})
