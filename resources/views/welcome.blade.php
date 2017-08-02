<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Blog Crawler</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.2/css/bulma.css"/>
    <style>
        .message {
            width: 450px;
            margin: auto;
        }

        .message-body {
            width: 450px;
            margin: auto;
        }

        .message.is-primary .message-header {
            width: 450px;
            margin: auto;
        }

        .footer {
            padding: inherit;
            margin-top: 20px;
        }
    </style>
    <script type="text/javascript">
        window.Laravel = window.Laravel || {};
        window.Laravel.csrfToken = "{{csrf_token()}}";
    </script>
</head>
<body>
<div id="app" style="display:none">
    <header>
        <nav class="nav">
            <div class="nav-left">
                 <div class="block">
                    <span class="tag is-primary">
                        Blog Crawler
                    </span>
                </div>
            </div>

            <div class="nav-right nav-menu block">
                <span class="nav-item">
                    <input class="input" type="search" name="search" placeholder="キーワード検索" v-model="keyWord">

                    <span class="select nav-item">
                        <select @change="sort" v-model="orderType">
                            <option value="new" selected>Sort by new Date</option>
                            <option value="old">Sort by old Date</option>
                        </select>
                    </span>
                </span>
            </div>
        </nav>
    </header>

    <div>
        <article class="message is-primary" v-for="blog in filterWord">
            <div class="message-header" >
                <a :href="blog.blog_url" target="_blank"><p>@{{ blog.blog_title }}</p></a>
            </div>
            <div class="message-body" >
                最終更新日時：@{{ blog.updated_at }}
            </div>
        </article>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="content has-text-centered">
                <p>&copy; 2017 Team Project Europa <br>
            </div>
        </div>
    </footer>
</div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/vue@2.3.4"></script>

    <script src="js/app.js"></script>

</body>
</html>