function getCookie(cookieName) {
  const name = cookieName + "="
  const decodedCookie = decodeURIComponent(document.cookie)
  const ca = decodedCookie.split(';')
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i]
    while (c.charAt(0) == ' ') {
      c = c.substring(1)
    }
// c.indexOf() function is used to find the index of the first occurrence of the search element provided as the argument to the function
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length)
    }
  }
  return ""
}

const posts = JSON.parse(getCookie('posts'))
const userPosts = JSON.parse(getCookie('userPosts'))

console.table(posts)
console.table(userPosts)
