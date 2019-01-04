const posts = JSON.parse(getCookie('posts'))
const container = document.querySelector('.posts-container')
console.table(posts)


posts.forEach((post, i) => {
container.innerHTML += `
<section class="feed-item">
<img class="feed-image" src="${post.image}"/>
<p>${post.description}</p>
<p>${post.created_at}</p>
</section>
`
})
