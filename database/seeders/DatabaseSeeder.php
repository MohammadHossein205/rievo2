<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Aboutus;
use App\Models\AdminFactorRequest;
use App\Models\Article;
use App\Models\Authimage;
use App\Models\Bankcard;
use App\Models\Card;
use App\Models\CardActivity;
use App\Models\Chartprice;
use App\Models\Comment;
use App\Models\Connecteddevices;
use App\Models\Contactus;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\Dashboardsetting;
use App\Models\DiscountCode;
use App\Models\Factor;
use App\Models\FactorDetail;
use App\Models\Fakecomment;
use App\Models\Faqsetting;
use App\Models\Group;
use App\Models\GroupCompany;
use App\Models\HusbandryText;
use App\Models\Indexpagesetting;
use App\Models\JoinNews;
use App\Models\Message;
use App\Models\Parvarbandi;
use App\Models\Payment;
use App\Models\PaymentCondition;
use App\Models\PaymentDetail;
use App\Models\Questionanswer;
use App\Models\Questionanswersetting;
use App\Models\Sell;
use App\Models\Tax;
use App\Models\Ticket;
use App\Models\Ticketgroupe;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        User::factory(10)->create();
//        Group::factory(20)->create();
//        GroupCompany::factory(20)->create();
//        Dam::factory(20)->create();
//        Damvizhe::factory(10)->create();
//        DiscountCode::factory(30)->create();
//        Comment::factory(20)->create();
//        Dashboardsetting::factory(1)->create();
//        Ticketgroupe::factory(10)->create();
//        Ticket::factory(10)->create();
//        Message::factory(20)->create();
//        Questionanswer::factory(20)->create();
//        Questionanswersetting::factory(10)->create();
//        Payment::factory(20)->create();
//        PaymentDetail::factory(20)->create();
//        Factor::factory(20)->create();
//        FactorDetail::factory(20)->create();
//        Bankcard::factory(20)->create();
//        JoinNews::factory(30)->create();
//        Connecteddevices::factory(30)->create();
//        Article::factory(10)->create();

//        Sell::factory(30)->create();
//        CardActivity::factory(30)->create();
//        Fakecomment::factory(10)->create();
//        Parvarbandi::factory(20)->create();
//        //----------------------------------------//

//        Chartprice::factory(20)->create();
//        Wallet::factory(1)->create();
//        HusbandryText::factory(1)->create();
//        WalletText::factory(1)->create();
//        Contactus::factory(1)->create();
//        Aboutus::factory(1)->create();
//        PaymentCondition::factory(1)->create();
//        Faqsetting::factory(5)->create();
//        Indexpagesetting::factory(1)->create();
//        Tax::factory(1)->create();
//        Authimage::factory(1)->create();

//        $user = User::create([
//            'username' => 'admin',
//            'fullname' => 'admin admin',
//            'image' => fake()->imageUrl(),
//            'nationalCode' => Str::random(10),
//            'mobile' => Str::random(11),
//            'homeNumber' => Str::random(11),
//            'birthDate' => fake()->date(),
//            'email' => 'admin@gmail.com',
//            'password' => Hash::make('admin'),
//            'address' => fake()->paragraph(30),
//        ]);
//        $wallet = Wallet::create([
//            'user_id' => 1,
//            'money' => 0,
//        ]);
//        $dashboardSetting = Dashboardsetting::create([
//            'user_id'=>1,
//            'email_notification'=>0,
//            'new_order_accept_sms'=>0,
//            'new_order_cancel_sms'=>0,
//        ]);
//        //--------------------------------------------//
//        $role = Role::create(['name' => 'admin']);
//        Role::create(['name' => 'writer']);
//        Role::create(['name' => 'user']);
//        //-------------------------------------------//
//        $permission = Permission::create(['name' => 'admin index', 'persian_name' => 'داشبورد']);
//
//        //users
//        Permission::create(['name' => 'users', 'persian_name' => 'کاربران']);
//        Permission::create(['name' => 'index users', 'persian_name' => 'همه کاربران']);
//        Permission::create(['name' => 'create user', 'persian_name' => 'افزودن کاربر']);
//        Permission::create(['name' => 'edit user', 'persian_name' => 'صفحه ویرایش کاربر']);
//        Permission::create(['name' => 'update user', 'persian_name' => 'ویرایش کاربر']);
//        Permission::create(['name' => 'delete user', 'persian_name' => 'حذف کاربر']);
//
//        //products
//        Permission::create(['name' => 'products', 'persian_name' => 'محصولات']);
//
//        //dam
//        Permission::create(['name' => 'dam', 'persian_name' => 'دام']);
//        Permission::create(['name' => 'index dams', 'persian_name' => 'همه دام ها']);
//        Permission::create(['name' => 'create dam', 'persian_name' => 'افزودن دام']);
//        Permission::create(['name' => 'edit dam', 'persian_name' => 'صفحه ویرایش دام']);
//        Permission::create(['name' => 'update dam', 'persian_name' => 'ویرایش دام']);
//        Permission::create(['name' => 'delete dam', 'persian_name' => 'حذف دام']);
//
//        //group
//        Permission::create(['name' => 'group', 'persian_name' => 'دسته بندی']);
//        Permission::create(['name' => 'create group', 'persian_name' => 'افزودن دسته بندی']);
//        Permission::create(['name' => 'edit group', 'persian_name' => 'صفحه ویرایش دسته بندی']);
//        Permission::create(['name' => 'update group', 'persian_name' => 'ویرایش دسته بندی']);
//        Permission::create(['name' => 'delete group', 'persian_name' => 'حذف دسته بندی']);
//
//        //groupcompany
//        Permission::create(['name' => 'groupcompany', 'persian_name' => 'شرکت دسته بندی']);
//        Permission::create(['name' => 'create groupcompany', 'persian_name' => 'افزودن شرکت دسته بندی']);
//        Permission::create(['name' => 'edit groupcompany', 'persian_name' => 'صفحه ویرایش شرکت دسته بندی']);
//        Permission::create(['name' => 'update groupcompany', 'persian_name' => 'ویرایش شرکت دسته بندی']);
//        Permission::create(['name' => 'delete groupcompany', 'persian_name' => 'حذف شرکت دسته بندی']);
//
//        //role
//        Permission::create(['name' => 'role', 'persian_name' => 'مقام']);
//        Permission::create(['name' => 'index roles', 'persian_name' => 'همه مقام ها']);
//        Permission::create(['name' => 'create role', 'persian_name' => 'افزودن مقام']);
//        Permission::create(['name' => 'edit role', 'persian_name' => 'صفحه ویرایش مقام']);
//        Permission::create(['name' => 'update role', 'persian_name' => 'ویرایش مقام']);
//        Permission::create(['name' => 'delete role', 'persian_name' => 'حذف مقام']);
//
//        //permission
//        Permission::create(['name' => 'permission', 'persian_name' => 'دسترسی']);
//        Permission::create(['name' => 'index permissions', 'persian_name' => 'همه دسترسی ها']);
//        Permission::create(['name' => 'create permission', 'persian_name' => 'افزودن دسترسی']);
//        Permission::create(['name' => 'edit permission', 'persian_name' => 'صفحه ویرایش دسترسی']);
//        Permission::create(['name' => 'update permission', 'persian_name' => 'ویرایش دسترسی']);
//        Permission::create(['name' => 'delete permission', 'persian_name' => 'حذف دسترسی']);
//
//        //discountcode
//        Permission::create(['name' => 'discountcode', 'persian_name' => 'تخفیف']);
//        Permission::create(['name' => 'index discountcodes', 'persian_name' => 'همه تخفیف ها']);
//        Permission::create(['name' => 'create discountcode', 'persian_name' => 'افزودن تخفیف']);
//        Permission::create(['name' => 'edit discountcode', 'persian_name' => 'صفحه ویرایش تخفیف']);
//        Permission::create(['name' => 'update discountcode', 'persian_name' => 'ویرایش تخفیف']);
//        Permission::create(['name' => 'delete discountcode', 'persian_name' => 'حذف تخفیف']);

//        //dam vizhe
//        Permission::create(['name' => 'damvizhe', 'persian_name' => 'دام ویژه']);
//        Permission::create(['name' => 'index damvizhes', 'persian_name' => 'همه دام ویژه ها']);
//        Permission::create(['name' => 'create damvizhe', 'persian_name' => 'افزودن دام ویژه']);
//        Permission::create(['name' => 'edit damvizhe', 'persian_name' => 'صفحه ویرایش دام ویژه']);
//        Permission::create(['name' => 'update damvizhe', 'persian_name' => 'ویرایش دام ویژه']);
//        Permission::create(['name' => 'delete damvizhe', 'persian_name' => 'حذف دام ویژه']);
//
//        //bank card
//        Permission::create(['name' => 'bankcard', 'persian_name' => 'کارت بانکی']);
//        Permission::create(['name' => 'index bankcards', 'persian_name' => 'همه کارت بانکی ها']);
//        Permission::create(['name' => 'status bankcard', 'persian_name' => 'تایید کارت بانکی']);
//        Permission::create(['name' => 'delete bankcard', 'persian_name' => 'حذف کارت بانکی']);
//
//        //comment
//        Permission::create(['name' => 'comment', 'persian_name' => 'کامنت']);
//        Permission::create(['name' => 'index comments', 'persian_name' => 'همه کامنت ها']);
//        Permission::create(['name' => 'seen comment', 'persian_name' => 'همشاهده کامنت']);
//        Permission::create(['name' => 'status comment', 'persian_name' => 'تایید کامنت']);
//        Permission::create(['name' => 'edit comment', 'persian_name' => 'صفحه ویرایش کامنت']);
//        Permission::create(['name' => 'update comment', 'persian_name' => 'ویرایش کامنت']);
//        Permission::create(['name' => 'delete comment', 'persian_name' => 'حذف کامنت']);
//
//        //ticket
//        Permission::create(['name' => 'ticket', 'persian_name' => 'تیکت']);
//        Permission::create(['name' => 'index tickets', 'persian_name' => 'همه تیکت ها']);
//        Permission::create(['name' => 'status ticket', 'persian_name' => 'تایید تیکت']);
//        Permission::create(['name' => 'show ticketgroupe', 'persian_name' => 'نمایش تیکت']);
//        Permission::create(['name' => 'delete ticket', 'persian_name' => 'حذف تیکت']);
//
//        //message
//        Permission::create(['name' => 'message', 'persian_name' => 'پیام']);
//        Permission::create(['name' => 'index messages', 'persian_name' => 'همه پیام ها']);
//        Permission::create(['name' => 'create message', 'persian_name' => 'افزودن پیام']);
//        Permission::create(['name' => 'edit message', 'persian_name' => 'صفحه ویرایش پیام']);
//        Permission::create(['name' => 'update message', 'persian_name' => 'ویرایش پیام']);
//        Permission::create(['name' => 'delete message', 'persian_name' => 'حذف پیام']);

//        //sell
//        Permission::create(['name' => 'selldam', 'persian_name' => 'درخواست فروش']);
//        Permission::create(['name' => 'index selldams', 'persian_name' => 'همه درخواست فروش ها']);
//        Permission::create(['name' => 'add selldam', 'persian_name' => 'ثبت فروش دام']);
//        Permission::create(['name' => 'delete selldam', 'persian_name' => 'حذف درخواست فروش دام']);
//
//        //question answer
//        Permission::create(['name' => 'questionanswer', 'persian_name' => 'سوال و جواب']);
//        Permission::create(['name' => 'index questionanswers', 'persian_name' => 'همه سوال و جواب ها']);
//        Permission::create(['name' => 'status questionanswer', 'persian_name' => 'تایید سوال و جواب']);
//        Permission::create(['name' => 'edit questionanswer', 'persian_name' => 'صفحه ویرایش سوال و جواب']);
//        Permission::create(['name' => 'update questionanswer', 'persian_name' => 'ویرایش سوال و جواب']);
//        Permission::create(['name' => 'delete questionanswer', 'persian_name' => 'حذف سوال و جواب']);

//        //question answer setting
//        Permission::create(['name' => 'questionanswersetting', 'persian_name' => 'متن تنظیمات سوال جواب']);
//        Permission::create(['name' => 'index questionanswersettings', 'persian_name' => 'همه متن تنظیمات سوال جواب ها']);
//        Permission::create(['name' => 'store questionanswersetting', 'persian_name' => 'افزودن متن تنظیمات سوال جواب']);
//        Permission::create(['name' => 'edit questionanswersetting', 'persian_name' => 'صفحه ویرایش متن تنظیمات سوال جواب']);
//        Permission::create(['name' => 'update questionanswersetting', 'persian_name' => 'ویرایش متن تنظیمات سوال جواب']);
//        Permission::create(['name' => 'delete questionanswersetting', 'persian_name' => 'حذف متن تنظیمات سوال جواب']);

//       //joinnews
//        Permission::create(['name' => 'joinnews', 'persian_name' => 'خبرنامه']);
//        Permission::create(['name' => 'index joinnews', 'persian_name' => 'همه خبرنامه ها']);

//
//        //faq setting
//        Permission::create(['name' => 'faqsetting', 'persian_name' => 'سوالات متداول']);
//        Permission::create(['name' => 'index faqsettings', 'persian_name' => 'همه سوالات متداول']);
//        Permission::create(['name' => 'create faqsetting', 'persian_name' => 'افزودن سوالات متداول']);
//        Permission::create(['name' => 'edit faqsetting', 'persian_name' => 'صفحه ویرایش سوالات متداول']);
//        Permission::create(['name' => 'update faqsetting', 'persian_name' => 'ویرایش سوالات متداول']);
//        Permission::create(['name' => 'delete faqsetting', 'persian_name' => 'حذف سوالات متداول']);

//        //chartprice
//        Permission::create(['name' => 'chartprice', 'persian_name' => 'نمودار']);
//        Permission::create(['name' => 'index chartprices', 'persian_name' => 'همه نمودار']);
//        Permission::create(['name' => 'create chartprice', 'persian_name' => 'افزودن نمودار']);
//        Permission::create(['name' => 'edit chartprice', 'persian_name' => 'صفحه ویرایش نمودار']);
//        Permission::create(['name' => 'update chartprice', 'persian_name' => 'ویرایش نمودار']);
//        Permission::create(['name' => 'delete chartprice', 'persian_name' => 'حذف نمودار']);
//
//        //payment
//        Permission::create(['name' => 'payment', 'persian_name' => 'مدیریت پرداخت']);
//        Permission::create(['name' => 'index payments', 'persian_name' => 'همه پرداختی ها']);
//        Permission::create(['name' => 'show detail payment', 'persian_name' => 'نمایش جزئیات پرداخت']);
//
//        //gallery
//        Permission::create(['name' => 'gallery', 'persian_name' => 'رسانه']);
//        Permission::create(['name' => 'index galleries', 'persian_name' => 'همه رسانه ها']);
//        Permission::create(['name' => 'create gallery', 'persian_name' => 'افزودن رسانه']);
//        Permission::create(['name' => 'delete gallery', 'persian_name' => 'حذف رسانه']);
//
//        //article
//        Permission::create(['name' => 'article', 'persian_name' => 'مقاله']);
//        Permission::create(['name' => 'index articles', 'persian_name' => 'همه مقاله ها']);
//        Permission::create(['name' => 'create article', 'persian_name' => 'افزودن مقاله']);
//        Permission::create(['name' => 'edit article', 'persian_name' => 'صفحه ویرایش مقاله']);
//        Permission::create(['name' => 'update article', 'persian_name' => 'ویرایش مقاله']);
//        Permission::create(['name' => 'delete article', 'persian_name' => 'حذف مقاله']);

//        //parvarbandi
//        Permission::create(['name' => 'parvarbandi', 'persian_name' => 'پرواربندی']);
//        Permission::create(['name' => 'index parvarbandis', 'persian_name' => 'همه پرواربندی ها']);
//        Permission::create(['name' => 'create parvarbandi', 'persian_name' => 'افزودن پرواربندی']);
//        Permission::create(['name' => 'edit parvarbandi', 'persian_name' => 'صفحه ویرایش پرواربندی']);
//        Permission::create(['name' => 'update parvarbandi', 'persian_name' => 'ویرایش پرواربندی']);
//        Permission::create(['name' => 'delete parvarbandi', 'persian_name' => 'حذف پرواربندی']);
//        Permission::create(['name' => 'show parvarbandi', 'persian_name' => 'نمایش پرواربندی']);

//        //factor
//        Permission::create(['name' => 'factor', 'persian_name' => 'فاکتور']);
//        Permission::create(['name' => 'index factors', 'persian_name' => 'همه فاکتور ها']);
//        Permission::create(['name' => 'create factor', 'persian_name' => 'افزودن فاکتور']);
//        Permission::create(['name' => 'edit factor', 'persian_name' => 'صفحه ویرایش فاکتور']);
//        Permission::create(['name' => 'update factor', 'persian_name' => 'ویرایش فاکتور']);
//        Permission::create(['name' => 'delete factor', 'persian_name' => 'حذف فاکتور']);
//        Permission::create(['name' => 'show detail factor', 'persian_name' => 'نمایش جزئیات فاکتور']);

//        //fake comment
//        Permission::create(['name' => 'fakecomment', 'persian_name' => 'کامنت فیک']);
//        Permission::create(['name' => 'index fakecomments', 'persian_name' => 'همه کامنت فیک ها']);
//        Permission::create(['name' => 'create fakecomment', 'persian_name' => 'افزودن کامنت فیک']);
//        Permission::create(['name' => 'edit fakecomment', 'persian_name' => 'صفحه ویرایش کامنت فیک']);
//        Permission::create(['name' => 'update fakecomment', 'persian_name' => 'ویرایش کامنت فیک']);
//        Permission::create(['name' => 'delete fakecomment', 'persian_name' => 'حذف کامنت فیک']);

//        //setting
//        Permission::create(['name' => 'setting', 'persian_name' => 'تنظیمات']);
//
//        //contactus
//        Permission::create(['name' => 'contactus', 'persian_name' => 'ارتباط با ما']);
//
//        //about us
//        Permission::create(['name' => 'aboutus', 'persian_name' => 'درباره ما']);

//        //husbandry text
//        Permission::create(['name' => 'husbandrytext', 'persian_name' => 'متن دامداری']);
//
//        //wallet text
//        Permission::create(['name' => 'wallettext', 'persian_name' => 'متن کیف پول']);
//
//        //index setting
//        Permission::create(['name' => 'index setting', 'persian_name' => 'تنظیمات صفحه اصلی']);
//
//
//        $role->givePermissionTo([1, 2, 3, 4, 5, 6, 7, 25, 26, 28, 29]);
//        $user->assignRole('admin');

    }
}
