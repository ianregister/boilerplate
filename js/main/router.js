//Routes tell the app what to do
routes:{
    "":"homeAction",

    "news/:page":"newsPostAction",
    "news":"loopNewsAction",

    "blog/categories/:page":"blogCategoryAction",
    "blog/:page":"blogArticleAction",

    "*page":"defaultAction"
},

