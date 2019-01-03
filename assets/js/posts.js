function getCookie(cookieName) {
  var name = cookieName + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
// c.indexOf() function is used to find the index of the first occurrence of the search element provided as the argument to the function
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

const posts = JSON.parse(getCookie('posts'))
const userPosts = JSON.parse(getCookie('userPosts'))

console.log(posts)
console.log(userPosts)

console.table(posts)
console.table(userPosts)
