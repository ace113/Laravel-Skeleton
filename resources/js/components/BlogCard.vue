<template>
    <div class="blogCard">
        <div class="blogCard__image">
            <img
                :src="blog.image_url"
                alt="blogImg"
            />
        </div>
        <div class="blogCard__content">
            <div class="blogCard__content--top">
                <div class="col">
                    <fa-icon :icon="['fas', 'calendar']" /> {{ blog.date }}
                </div>
                <div class="col">
                    <fa-icon :icon="['fas', 'user']" /> {{ blog.author }}
                </div>
            </div>
            <div class="blogCard__content--header">
                {{ blog.title }}
            </div>
            <div class="blogCard__content--summary">
                {{ blog.summary }}
            </div>
            <div class="blogCard__content--read">
                <router-link :to="{ name: 'Blog', params: {slug : blog.slug}}">Continue Reading</router-link>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    // data(){
    //     return {
    //         title: "This is title of the blog",
    //         summary: "This is the summary of the blog. I don't know what to write...",
    //         date: "Sept. 27,2021",
    //         author: "Admin"
    //     }
    // },
    props: ["blog"],
};
</script>
