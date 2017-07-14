new Vue({
    el: '#app',
    data: {
        blogs: [],
        keyWord: '',
        orderType: 'new',
    },
    mounted() {
        // When the first time display, {{}} is reflected on display. To hide {{}}, just for a moment hide Vue object.
        document.getElementById("app").style.display = '';
        axios.get('/getblogsdata').then(response => this.blogs = response.data);
    },
    methods: {
        sort: function() {
            if (this.orderType === 'new') {
                this.blogs.sort(function(a, b){
                    if(a.updated_at > b.updated_at) return -1;
                    if(a.updated_at < b.updated_at) return 1;
                    return 0;
                });
            } else {
                this.blogs.sort(function(a, b){
                    if(a.updated_at < b.updated_at) return -1;
                    if(a.updated_at > b.updated_at) return 1;
                    return 0;
                });
            }
        },
        search: function () {
            var filterWord = this.keyWord;
            var array = new Array();
            if (filterWord) {
                this.blogs.forEach(function(element) {
                    if (element.blog_title.indexOf(filterWord) != -1) {
                        array.push(element);
                    }                    
                });
                this.blogs = array;
            } else {
                axios.get('/getblogsdata').then(response => this.blogs = response.data);
            }
        }
    }
});

