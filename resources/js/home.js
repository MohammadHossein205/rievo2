import {createApp} from "vue/dist/vue.esm-bundler";

import EditUser from "./home/user/EditUser.vue";
import NotificationSetting from "@/home/user/NotificationSetting.vue";
import UserWallet from "@/home/user/UserWallet.vue";
import Card from "@/home/user/wallet/Card.vue";
import BuyDam from "@/home/singleDam/BuyDam.vue";
import Cart from "@/home/user/cart/Cart.vue";
import CartMethod from "./home/user/cart/CartMethod.vue";
import BtnLike from "./components/like/BtnLike.vue";
import Shop from "./home/shop/Shop.vue";
import CardComponent from "./home/card/CardComponent.vue";
import DetailFactor from "./home/husbandry/DetailFactor.vue";
import UserDam from "./home/husbandry/UserDam.vue";
import BlogRateComponent from "./home/blog/BlogRateComponent.vue"


//single dam slider
import SingleDamSlider from "./components/sweiper slides/SingleDamSlider.vue";

//resend code
import SendSms from "./components/countDown/SendSms.vue";

//search dam
import SearchDam from "./home/search/SearchDam.vue";

//Husbandry
import Husbandry from "./home/husbandry/Husbandry.vue";

//cart activity
import CardActivity from "./home/user/wallet/CardActivity.vue";

//user profit
import UserProfit from "./home/user/husbandry/UserProfit.vue";

//price chart
import PriceChart from "./home/user/husbandry/PriceChart.vue";

//user activity
import UserActivity from "./home/user/husbandry/UserActivity.vue";

//user chart
import UserDamTable from "./home/userDam/UserDamTable.vue";

//user chart
import UserChart from "./home/user/husbandry/UserChart.vue";
//chart
import ChartComponent from "./home/ChartComponent.vue";

//paginate vue
import VueAwesomePaginate from "vue-awesome-paginate";
import "vue-awesome-paginate/dist/style.css";
import BlogPaginateComponent from "././home/blog/BlogPaginateComponent.vue";

//message
import Message from "./home/user/message/Message.vue";
// date picker
import DatePicker from "vue3-persian-datetime-picker";

import BlogArchive from "./home/blog/BlogArchive.vue";


//toaser
import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
// infinite scroll
import InfiniteLoading from "v3-infinite-loading";
import "v3-infinite-loading/lib/style.css";
//comment
import FormComment from "./home/singleDam/comment/FormComment.vue";
import ListComments from "./home/singleDam/comment/ListComments.vue";

//blog-comment
import FormBlogComment from "./home/singleblog/comment/FormBlogComment.vue";
import ListBlogComment from "./home/singleblog/comment/ListBlogComment.vue";

//question answer
import FormQuestionAnswer from "./home/singleDam/questionAnswer/FormQuestionAnswer.vue";
import ListQuestionAnswers from "./home/singleDam/questionAnswer/ListQuestionAnswers.vue";

//rate range
import RateRangeComponent from "./components/rateRange/RateRangeComponent.vue";

//rate
import RateComponent from "./components/rate/RateComponent.vue";

// send ticket
import UserSendTicket from "./home/user/sendticket/UserSendTicket.vue"


const app = createApp({});

app.use(Vue3Toasity, {autoClose: 3000});

// ------------------
app.component('EditUser', EditUser);
app.component('NotificationSetting', NotificationSetting);
app.component('UserWallet', UserWallet);
app.component('Card', Card);
app.component('BuyDam', BuyDam);
app.component('Cart', Cart);
app.component('BtnLike', BtnLike);
app.component('Shop', Shop);
app.component('CardComponent', CardComponent);
app.component('UserDam', UserDam);

//single dam slider
app.component('SingleDamSlider', SingleDamSlider)

//resend code
app.component('SendSms', SendSms)

//search dam
app.component('SearchDam', SearchDam)

//Husbandry
app.component('Husbandry', Husbandry)

//card activity
app.component('CardActivity', CardActivity)

//user profit
app.component('UserProfit', UserProfit)

//price chart
app.component('PriceChart', PriceChart)

//user activity
app.component('UserActivity', UserActivity)

//user chart
app.component('UserDamTable', UserDamTable)

//user chart
app.component('UserChart', UserChart)

//paginate vue
app.use(VueAwesomePaginate);
app.component('BlogPaginateComponent', BlogPaginateComponent);


app.component('ChartComponent', ChartComponent);


// Vue Countdown
// app.component(VueCountdown.name, VueCountdown);

// message
app.component('Message', Message);

// date picker
app.component('DatePicker', DatePicker);

// infinite scroll
app.component("infinite-loading", InfiniteLoading);
//factor
app.component('DetailFactor', DetailFactor);

//cart
app.component('CartMethod', CartMethod);

//comment
app.component('FormComment', FormComment);
app.component('ListComments', ListComments);

//comment
app.component('FormQuestionAnswer', FormQuestionAnswer);
app.component('ListQuestionAnswers', ListQuestionAnswers);

//blog-comment
app.component('FormBlogComment', FormBlogComment);
app.component('ListBlogComment', ListBlogComment);

// blog rate
app.component('BlogRateComponent', BlogRateComponent);


//user send ticket
app.component('UserSendTicket', UserSendTicket);

//rate
app.component('RateComponent', RateComponent);

//rate range
app.component('RateRangeComponent', RateRangeComponent);

//blog archive
app.component('BlogArchive', BlogArchive);

app.mount('#app');
