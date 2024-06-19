<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create(['name'=>'Afghanistan', 'code' => 'AF', 'tel_code'=>'+93', 'flag'=>'https://flagcdn.com/af.svg']);
        Country::create(['name'=>'Albania', 'code' => 'AL', 'tel_code'=>'+355', 'flag'=>'https://flagcdn.com/al.svg']);
        Country::create(['name'=>'Algeria', 'code' => 'DZ', 'tel_code'=>'+213', 'flag'=>'https://flagcdn.com/dz.svg']);
        Country::create(['name'=>'American Samoa', 'code' => 'AS', 'tel_code'=>'+1684', 'flag'=>'https://flagcdn.com/as.svg']);
        Country::create(['name'=>'Andorra', 'code' => 'AD', 'tel_code'=>'+376', 'flag'=>'https://flagcdn.com/ad.svg']);
        Country::create(['name'=>'Angola', 'code' => 'AO', 'tel_code'=>'+244', 'flag'=>'https://flagcdn.com/ao.svg']);
        Country::create(['name'=>'Anguilla', 'code' => 'AI', 'tel_code'=>'+1264', 'flag'=>'https://flagcdn.com/ai.svg']);
        Country::create(['name'=>'Antarctica', 'code' => 'AQ', 'tel_code'=>'+672', 'flag'=>'https://flagcdn.com/aq.svg']);
        Country::create(['name'=>'Antigua and Barbuda', 'code' => 'AG', 'tel_code'=>'+1268', 'flag'=>'https://flagcdn.com/ag.svg']);
        Country::create(['name'=>'Argentina', 'code' => 'AR', 'tel_code'=>'+54', 'flag'=>'https://flagcdn.com/ar.svg']);
        Country::create(['name'=>'Armenia', 'code' => 'AM', 'tel_code'=>'+374', 'flag'=>'https://flagcdn.com/am.svg']);
        Country::create(['name'=>'Aruba', 'code' => 'AW', 'tel_code'=>'+297', 'flag'=>'https://flagcdn.com/aw.svg']);
        Country::create(['name'=>'Australia', 'code' => 'AU', 'tel_code'=>'+61', 'timezone'=>'Australia/Sydney', 'flag'=>'https://flagcdn.com/au.svg']);
        Country::create(['name'=>'Austria', 'code' => 'AT', 'tel_code'=>'+43', 'flag'=>'https://flagcdn.com/at.svg']);
        Country::create(['name'=>'Azerbaijan', 'code' => 'AZ', 'tel_code'=>'+994', 'flag'=>'https://flagcdn.com/az.svg']);
        
        Country::create(['name'=>'Bahamas', 'code' => 'BS', 'tel_code'=>'+1242', 'flag'=>'https://flagcdn.com/bs.svg']);
        Country::create(['name'=>'Bahrain', 'code' => 'BH', 'tel_code'=>'+973', 'flag'=>'https://flagcdn.com/bh.svg']);
        Country::create(['name'=>'Bangladesh', 'code' => 'BD', 'tel_code'=>'+880', 'timezone'=>'Asia/Dhaka', 'flag'=>'https://flagcdn.com/bd.svg']);
        Country::create(['name'=>'Barbados', 'code' => 'BB', 'tel_code'=>'+1246', 'flag'=>'https://flagcdn.com/bb.svg']);
        Country::create(['name'=>'Belarus', 'code' => 'BY', 'tel_code'=>'+375', 'flag'=>'https://flagcdn.com/by.svg']);
        Country::create(['name'=>'Belgium', 'code' => 'BE', 'tel_code'=>'+32', 'flag'=>'https://flagcdn.com/be.svg']);
        Country::create(['name'=>'Belize', 'code' => 'BZ', 'tel_code'=>'+501', 'flag'=>'https://flagcdn.com/bz.svg']);
        Country::create(['name'=>'Benin', 'code' => 'BJ', 'tel_code'=>'+229', 'flag'=>'https://flagcdn.com/bj.svg']);
        Country::create(['name'=>'Bermuda', 'code' => 'BM', 'tel_code'=>'+1441', 'flag'=>'https://flagcdn.com/bm.svg']);
        Country::create(['name'=>'Bhutan', 'code' => 'BT', 'tel_code'=>'+975', 'timezone'=>'Asia/Thimphu', 'flag'=>'https://flagcdn.com/bt.svg']);
        Country::create(['name'=>'Bolivia', 'code' => 'BO', 'tel_code'=>'+591', 'flag'=>'https://flagcdn.com/bo.svg']);
        Country::create(['name'=>'Bosnia and Herzegovina', 'code' => 'BA', 'tel_code'=>'+387', 'flag'=>'https://flagcdn.com/ba.svg']);
        Country::create(['name'=>'Botswana', 'code' => 'BW', 'tel_code'=>'+267', 'flag'=>'https://flagcdn.com/bw.svg']);
        Country::create(['name'=>'Brazil', 'code' => 'BR', 'tel_code'=>'+55', 'flag'=>'https://flagcdn.com/br.svg']);
        Country::create(['name'=>'British Indian Ocean Territory', 'code' => 'IO', 'tel_code'=>'+246', 'flag'=>'https://flagcdn.com/io.svg']);
        Country::create(['name'=>'British Virgin Islands', 'code' => 'VG', 'tel_code'=>'+1284', 'flag'=>'https://flagcdn.com/vg.svg']);
        Country::create(['name'=>'Brunei', 'code' => 'BN', 'tel_code'=>'+673', 'flag'=>'https://flagcdn.com/bn.svg']);
        Country::create(['name'=>'Bulgaria', 'code' => 'BG', 'tel_code'=>'+359', 'flag'=>'https://flagcdn.com/bg.svg']);
        Country::create(['name'=>'Burkina Faso', 'code' => 'BF', 'tel_code'=>'+226', 'flag'=>'https://flagcdn.com/bf.svg']);
        Country::create(['name'=>'Burundi', 'code' => 'BI', 'tel_code'=>'+257', 'flag'=>'https://flagcdn.com/bi.svg']);

        Country::create(['name'=>'Cambodia', 'code' => 'KH', 'tel_code'=>'+855', 'flag'=>'https://flagcdn.com/kh.svg']);
        Country::create(['name'=>'Cameroon', 'code' => 'CM', 'tel_code'=>'+237', 'flag'=>'https://flagcdn.com/cm.svg']);
        Country::create(['name'=>'Canada', 'code' => 'CA', 'tel_code'=>'+1', 'timezone'=>'America/Toronto', 'flag'=>'https://flagcdn.com/ca.svg']);
        Country::create(['name'=>'Cape Verde', 'code' => 'CV', 'tel_code'=>'+238', 'flag'=>'https://flagcdn.com/cv.svg']);
        Country::create(['name'=>'Cayman Islands', 'code' => 'KY', 'tel_code'=>'+1345', 'flag'=>'https://flagcdn.com/ky.svg']);
        Country::create(['name'=>'Central African Republic', 'code' => 'CF', 'tel_code'=>'+236', 'flag'=>'https://flagcdn.com/cf.svg']);
        Country::create(['name'=>'Chad', 'code' => 'TD', 'tel_code'=>'+235', 'flag'=>'https://flagcdn.com/td.svg']);
        Country::create(['name'=>'Chile', 'code' => 'CL', 'tel_code'=>'+56', 'flag'=>'https://flagcdn.com/cl.svg']);
        Country::create(['name'=>'China', 'code' => 'CN', 'tel_code'=>'+86', 'flag'=>'https://flagcdn.com/cn.svg']);
        Country::create(['name'=>'Christmas Island', 'code' => 'CX', 'tel_code'=>'+61', 'flag'=>'https://flagcdn.com/cx.svg']);
        Country::create(['name'=>'Cocos Islands', 'code' => 'CC', 'tel_code'=>'+61', 'flag'=>'https://flagcdn.com/cc.svg']);
        Country::create(['name'=>'Colombia', 'code' => 'CO', 'tel_code'=>'+57', 'flag'=>'https://flagcdn.com/co.svg']);
        Country::create(['name'=>'Comoros', 'code' => 'KM', 'tel_code'=>'+269', 'flag'=>'https://flagcdn.com/km.svg']);
        Country::create(['name'=>'Cook Islands', 'code' => 'CK', 'tel_code'=>'+682', 'flag'=>'https://flagcdn.com/ck.svg']);
        Country::create(['name'=>'Costa Rica', 'code' => 'CR', 'tel_code'=>'+506', 'flag'=>'https://flagcdn.com/cr.svg']);
        Country::create(['name'=>'Croatia', 'code' => 'HR', 'tel_code'=>'+385', 'flag'=>'https://flagcdn.com/hr.svg']);
        Country::create(['name'=>'Cuba', 'code' => 'CU', 'tel_code'=>'+53', 'flag'=>'https://flagcdn.com/cu.svg']);
        Country::create(['name'=>'Curacao', 'code' => 'CW', 'tel_code'=>'+599', 'flag'=>'https://flagcdn.com/cw.svg']);
        Country::create(['name'=>'Cyprus', 'code' => 'CY', 'tel_code'=>'+357', 'flag'=>'https://flagcdn.com/cy.svg']);
        Country::create(['name'=>'Czech Republic', 'code' => 'CZ', 'tel_code'=>'+420', 'flag'=>'https://flagcdn.com/cz.svg']);

        Country::create(['name'=>'Democratic Republic of the Congo', 'code' => 'CD', 'tel_code'=>'+243', 'flag'=>'https://flagcdn.com/cd.svg']);
        Country::create(['name'=>'Denmark', 'code' => 'DK', 'tel_code'=>'+45', 'flag'=>'https://flagcdn.com/dk.svg']);
        Country::create(['name'=>'Djibouti', 'code' => 'DJ', 'tel_code'=>'+253', 'flag'=>'https://flagcdn.com/dj.svg']);
        Country::create(['name'=>'Dominica', 'code' => 'DM', 'tel_code'=>'+1767', 'flag'=>'https://flagcdn.com/dm.svg']);
        Country::create(['name'=>'Dominican Republic', 'code' => 'DO', 'tel_code'=>'+1809', 'flag'=>'https://flagcdn.com/do.svg']);

        Country::create(['name'=>'East Timor', 'code' => 'TL', 'tel_code'=>'+670', 'flag'=>'https://flagcdn.com/tl.svg']);
        Country::create(['name'=>'Ecuador', 'code' => 'EC', 'tel_code'=>'+593', 'flag'=>'https://flagcdn.com/ec.svg']);
        Country::create(['name'=>'Egypt', 'code' => 'EG', 'tel_code'=>'+20', 'flag'=>'https://flagcdn.com/eg.svg']);
        Country::create(['name'=>'El Salvador', 'code' => 'SV', 'tel_code'=>'+503', 'flag'=>'https://flagcdn.com/sv.svg']);
        Country::create(['name'=>'Equatorial Guinea', 'code' => 'GQ', 'tel_code'=>'+240', 'flag'=>'https://flagcdn.com/gq.svg']);
        Country::create(['name'=>'Eritrea', 'code' => 'ER', 'tel_code'=>'+291', 'flag'=>'https://flagcdn.com/er.svg']);
        Country::create(['name'=>'Estonia', 'code' => 'EE', 'tel_code'=>'+372', 'flag'=>'https://flagcdn.com/ee.svg']);
        Country::create(['name'=>'Ethiopia', 'code' => 'ET', 'tel_code'=>'+251', 'flag'=>'https://flagcdn.com/et.svg']);

        Country::create(['name'=>'Falkland Islands', 'code' => 'FK', 'tel_code'=>'+500', 'flag'=>'https://flagcdn.com/fk.svg']);
        Country::create(['name'=>'Faroe Islands', 'code' => 'FO', 'tel_code'=>'+298', 'flag'=>'https://flagcdn.com/fo.svg']);
        Country::create(['name'=>'Fiji', 'code' => 'FJ', 'tel_code'=>'+679', 'flag'=>'https://flagcdn.com/fj.svg']);
        Country::create(['name'=>'Finland', 'code' => 'FI', 'tel_code'=>'+358', 'flag'=>'https://flagcdn.com/fi.svg']);
        Country::create(['name'=>'France', 'code' => 'FR', 'tel_code'=>'+33', 'flag'=>'https://flagcdn.com/fr.svg']);
        Country::create(['name'=>'French Polynesia', 'code' => 'PF', 'tel_code'=>'+689', 'flag'=>'https://flagcdn.com/pf.svg']);

        Country::create(['name'=>'Gabon', 'code' => 'GA', 'tel_code'=>'+241', 'flag'=>'https://flagcdn.com/ga.svg']);
        Country::create(['name'=>'Gambia', 'code' => 'GM', 'tel_code'=>'+220', 'flag'=>'https://flagcdn.com/gm.svg']);
        Country::create(['name'=>'Georgia', 'code' => 'GE', 'tel_code'=>'+995', 'flag'=>'https://flagcdn.com/ge.svg']);
        Country::create(['name'=>'Germany', 'code' => 'DE', 'tel_code'=>'+49', 'flag'=>'https://flagcdn.com/de.svg']);
        Country::create(['name'=>'Ghana', 'code' => 'GH', 'tel_code'=>'+233', 'flag'=>'https://flagcdn.com/gh.svg']);
        Country::create(['name'=>'Gibraltar', 'code' => 'GI', 'tel_code'=>'+350', 'flag'=>'https://flagcdn.com/gi.svg']);
        Country::create(['name'=>'Greece', 'code' => 'GR', 'tel_code'=>'+30', 'flag'=>'https://flagcdn.com/gr.svg']);
        Country::create(['name'=>'Greenland', 'code' => 'GL', 'tel_code'=>'+299', 'flag'=>'https://flagcdn.com/gl.svg']);
        Country::create(['name'=>'Grenada', 'code' => 'GD', 'tel_code'=>'+1473', 'flag'=>'https://flagcdn.com/gd.svg']);
        Country::create(['name'=>'Guam', 'code' => 'GU', 'tel_code'=>'+1671', 'flag'=>'https://flagcdn.com/gu.svg']);
        Country::create(['name'=>'Guatemala', 'code' => 'GT', 'tel_code'=>'+502', 'flag'=>'https://flagcdn.com/gt.svg']);
        Country::create(['name'=>'Guernsey', 'code' => 'GG', 'tel_code'=>'+441481', 'flag'=>'https://flagcdn.com/gg.svg']);
        Country::create(['name'=>'Guinea', 'code' => 'GN', 'tel_code'=>'+224', 'flag'=>'https://flagcdn.com/gn.svg']);
        Country::create(['name'=>'Guinea-Bissau', 'code' => 'GW', 'tel_code'=>'+245', 'flag'=>'https://flagcdn.com/gw.svg']);
        Country::create(['name'=>'Guyana', 'code' => 'GY', 'tel_code'=>'+592', 'flag'=>'https://flagcdn.com/gy.svg']);

        Country::create(['name'=>'Haiti', 'code' => 'HT', 'tel_code'=>'+509', 'flag'=>'https://flagcdn.com/ht.svg']);
        Country::create(['name'=>'Honduras', 'code' => 'HN', 'tel_code'=>'+504', 'flag'=>'https://flagcdn.com/hn.svg']);
        Country::create(['name'=>'Hong Kong', 'code' => 'HK', 'tel_code'=>'+852', 'flag'=>'https://flagcdn.com/hk.svg']);
        Country::create(['name'=>'Hungary', 'code' => 'HU', 'tel_code'=>'+36', 'flag'=>'https://flagcdn.com/hu.svg']);

        Country::create(['name'=>'Iceland', 'code' => 'IS', 'tel_code'=>'+354', 'flag'=>'https://flagcdn.com/is.svg']);
        Country::create(['name'=>'India', 'code' => 'IN', 'tel_code'=>'+91','timezone'=>'Asia/Kolkata', 'flag'=>'https://flagcdn.com/in.svg']);
        Country::create(['name'=>'Indonesia', 'code' => 'ID', 'tel_code'=>'+62', 'flag'=>'https://flagcdn.com/id.svg']);
        Country::create(['name'=>'Iran', 'code' => 'IR', 'tel_code'=>'+98', 'flag'=>'https://flagcdn.com/ir.svg']);
        Country::create(['name'=>'Iraq', 'code' => 'IQ', 'tel_code'=>'+964', 'flag'=>'https://flagcdn.com/iq.svg']);
        Country::create(['name'=>'Ireland', 'code' => 'IE', 'tel_code'=>'+353', 'flag'=>'https://flagcdn.com/ie.svg']);
        Country::create(['name'=>'Isle of Man', 'code' => 'IM', 'tel_code'=>'+441624', 'flag'=>'https://flagcdn.com/im.svg']);
        Country::create(['name'=>'Israel', 'code' => 'IL', 'tel_code'=>'+972', 'flag'=>'https://flagcdn.com/il.svg']);
        Country::create(['name'=>'Italy', 'code' => 'IT', 'tel_code'=>'+39', 'flag'=>'https://flagcdn.com/it.svg']);
        Country::create(['name'=>'Ivory Coast', 'code' => 'CI', 'tel_code'=>'+225', 'flag'=>'https://flagcdn.com/ci.svg']);

        Country::create(['name'=>'Jamaica', 'code' => 'JM', 'tel_code'=>'+1876', 'flag'=>'https://flagcdn.com/jm.svg']);
        Country::create(['name'=>'Japan', 'code' => 'JP', 'tel_code'=>'+81', 'flag'=>'https://flagcdn.com/jp.svg']);
        Country::create(['name'=>'Jersey', 'code' => 'JE', 'tel_code'=>'+441534', 'flag'=>'https://flagcdn.com/je.svg']);
        Country::create(['name'=>'Jordan', 'code' => 'JO', 'tel_code'=>'+962', 'flag'=>'https://flagcdn.com/jo.svg']);

        Country::create(['name'=>'Kazakhstan', 'code' => 'KZ', 'tel_code'=>'+7', 'flag'=>'https://flagcdn.com/kz.svg']);
        Country::create(['name'=>'Kenya', 'code' => 'KE', 'tel_code'=>'+254', 'flag'=>'https://flagcdn.com/ke.svg']);
        Country::create(['name'=>'Kiribati', 'code' => 'KI', 'tel_code'=>'+686', 'flag'=>'https://flagcdn.com/ki.svg']);
        Country::create(['name'=>'Kosovo', 'code' => 'XK', 'tel_code'=>'+383', 'flag'=>'https://flagcdn.com/xk.svg']);
        Country::create(['name'=>'Kuwait', 'code' => 'KW', 'tel_code'=>'+965', 'flag'=>'https://flagcdn.com/kw.svg']);
        Country::create(['name'=>'Kyrgyzstan', 'code' => 'KG', 'tel_code'=>'+996', 'flag'=>'https://flagcdn.com/KG.svg']);

        Country::create(['name'=>'Laos', 'code' => 'LA', 'tel_code'=>'+856', 'flag'=>'https://flagcdn.com/la.svg']);
        Country::create(['name'=>'Latvia', 'code' => 'LV', 'tel_code'=>'+371', 'flag'=>'https://flagcdn.com/lv.svg']);
        Country::create(['name'=>'Lebanon', 'code' => 'LB', 'tel_code'=>'+961', 'flag'=>'https://flagcdn.com/lb.svg']);
        Country::create(['name'=>'Lesotho', 'code' => 'LS', 'tel_code'=>'+266', 'flag'=>'https://flagcdn.com/ls.svg']);
        Country::create(['name'=>'Liberia', 'code' => 'LR', 'tel_code'=>'+231', 'flag'=>'https://flagcdn.com/lr.svg']);
        Country::create(['name'=>'Libya', 'code' => 'LY', 'tel_code'=>'+218', 'flag'=>'https://flagcdn.com/ly.svg']);
        Country::create(['name'=>'Liechtenstein', 'code' => 'LI', 'tel_code'=>'+423', 'flag'=>'https://flagcdn.com/li.svg']);
        Country::create(['name'=>'Lithuania', 'code' => 'LT', 'tel_code'=>'+370', 'flag'=>'https://flagcdn.com/lt.svg']);
        Country::create(['name'=>'Luxembourg', 'code' => 'LU', 'tel_code'=>'+352', 'flag'=>'https://flagcdn.com/lu.svg']);

        Country::create(['name'=>'Macau', 'code' => 'MO', 'tel_code'=>'+853', 'flag'=>'https://flagcdn.com/mo.svg']);
        Country::create(['name'=>'Macedonia', 'code' => 'MK', 'tel_code'=>'+389', 'flag'=>'https://flagcdn.com/mk.svg']);
        Country::create(['name'=>'Madagascar', 'code' => 'MG', 'tel_code'=>'+261', 'flag'=>'https://flagcdn.com/mg.svg']);
        Country::create(['name'=>'Malawi', 'code' => 'MW', 'tel_code'=>'+265', 'flag'=>'https://flagcdn.com/mw.svg']);
        Country::create(['name'=>'Malaysia', 'code' => 'MY', 'tel_code'=>'+60', 'flag'=>'https://flagcdn.com/my.svg']);
        Country::create(['name'=>'Maldives', 'code' => 'MV', 'tel_code'=>'+960', 'flag'=>'https://flagcdn.com/mv.svg']);
        Country::create(['name'=>'Mali', 'code' => 'ML', 'tel_code'=>'+223', 'flag'=>'https://flagcdn.com/ml.svg']);
        Country::create(['name'=>'Malta', 'code' => 'MT', 'tel_code'=>'+356', 'flag'=>'https://flagcdn.com/mt.svg']);
        Country::create(['name'=>'Marshall Islands', 'code' => 'MH', 'tel_code'=>'+692', 'flag'=>'https://flagcdn.com/mh.svg']);
        Country::create(['name'=>'Mauritania', 'code' => 'MR', 'tel_code'=>'+222', 'flag'=>'https://flagcdn.com/mr.svg']);
        Country::create(['name'=>'Mauritius', 'code' => 'MU', 'tel_code'=>'+230', 'flag'=>'https://flagcdn.com/mu.svg']);
        Country::create(['name'=>'Mayotte', 'code' => 'YT', 'tel_code'=>'+262', 'flag'=>'https://flagcdn.com/yt.svg']);
        Country::create(['name'=>'Mexico', 'code' => 'MX', 'tel_code'=>'+52', 'flag'=>'https://flagcdn.com/mx.svg']);
        Country::create(['name'=>'Micronesia', 'code' => 'FM', 'tel_code'=>'+691', 'flag'=>'https://flagcdn.com/fm.svg']);
        Country::create(['name'=>'Moldova', 'code' => 'MD', 'tel_code'=>'+373', 'flag'=>'https://flagcdn.com/md.svg']);
        Country::create(['name'=>'Monaco', 'code' => 'MC', 'tel_code'=>'+377', 'flag'=>'https://flagcdn.com/mc.svg']);
        Country::create(['name'=>'Mongolia', 'code' => 'MN', 'tel_code'=>'+976', 'flag'=>'https://flagcdn.com/mn.svg']);
        Country::create(['name'=>'Montenegro', 'code' => 'ME', 'tel_code'=>'+382', 'flag'=>'https://flagcdn.com/me.svg']);
        Country::create(['name'=>'Montserrat', 'code' => 'MS', 'tel_code'=>'+1664', 'flag'=>'https://flagcdn.com/ms.svg']);
        Country::create(['name'=>'Morocco', 'code' => 'MA', 'tel_code'=>'+212', 'flag'=>'https://flagcdn.com/ma.svg']);
        Country::create(['name'=>'Mozambique', 'code' => 'MZ', 'tel_code'=>'+258', 'flag'=>'https://flagcdn.com/mz.svg']);
        Country::create(['name'=>'Myanmar', 'code' => 'MM', 'tel_code'=>'+95', 'flag'=>'https://flagcdn.com/mm.svg']);

        Country::create(['name'=>'Namibia', 'code' => 'NA', 'tel_code'=>'+264', 'flag'=>'https://flagcdn.com/na.svg']);
        Country::create(['name'=>'Nauru', 'code' => 'NR', 'tel_code'=>'+674', 'flag'=>'https://flagcdn.com/nr.svg']);
        Country::create(['name'=>'Nepal', 'code' => 'NP', 'tel_code'=>'+977', 'timezone'=>'Asia/Kathmandu', 'flag'=>'https://flagcdn.com/np.svg']);
        Country::create(['name'=>'Netherlands', 'code' => 'NL', 'tel_code'=>'+31', 'flag'=>'https://flagcdn.com/nl.svg']);
        Country::create(['name'=>'New Caledonia', 'code' => 'NC', 'tel_code'=>'+687', 'flag'=>'https://flagcdn.com/nc.svg']);
        Country::create(['name'=>'New Zealand', 'code' => 'NZ', 'tel_code'=>'+64', 'flag'=>'https://flagcdn.com/nz.svg']);
        Country::create(['name'=>'Nicaragua', 'code' => 'NI', 'tel_code'=>'+505', 'flag'=>'https://flagcdn.com/ni.svg']);
        Country::create(['name'=>'Niger', 'code' => 'NE', 'tel_code'=>'+227', 'flag'=>'https://flagcdn.com/ne.svg']);
        Country::create(['name'=>'Nigeria', 'code' => 'NG', 'tel_code'=>'+234', 'flag'=>'https://flagcdn.com/ng.svg']);
        Country::create(['name'=>'Niue', 'code' => 'NU', 'tel_code'=>'+683', 'flag'=>'https://flagcdn.com/nu.svg']);
        Country::create(['name'=>'North Korea', 'code' => 'KP', 'tel_code'=>'+850', 'flag'=>'https://flagcdn.com/kp.svg']);
        Country::create(['name'=>'Northern Mariana Islands', 'code' => 'MP', 'tel_code'=>'+1670', 'flag'=>'https://flagcdn.com/mp.svg']);
        Country::create(['name'=>'Norway', 'code' => 'NO', 'tel_code'=>'+47', 'flag'=>'https://flagcdn.com/no.svg']);

        Country::create(['name'=>'Oman', 'code' => 'OM', 'tel_code'=>'+968', 'flag'=>'https://flagcdn.com/om.svg']);

        Country::create(['name'=>'Pakistan', 'code' => 'PK', 'tel_code'=>'+92', 'timezone'=>'Asia/Karachi', 'flag'=>'https://flagcdn.com/pk.svg']);
        Country::create(['name'=>'Palau', 'code' => 'PW', 'tel_code'=>'+680', 'flag'=>'https://flagcdn.com/pw.svg']);
        Country::create(['name'=>'Palestine', 'code' => 'PS', 'tel_code'=>'+970', 'flag'=>'https://flagcdn.com/ps.svg']);
        Country::create(['name'=>'Panama', 'code' => 'PA', 'tel_code'=>'+507', 'flag'=>'https://flagcdn.com/pa.svg']);
        Country::create(['name'=>'Papua New Guinea', 'code' => 'PG', 'tel_code'=>'+675', 'flag'=>'https://flagcdn.com/pg.svg']);
        Country::create(['name'=>'Paraguay', 'code' => 'PY', 'tel_code'=>'+595', 'flag'=>'https://flagcdn.com/py.svg']);
        Country::create(['name'=>'Peru', 'code' => 'PE', 'tel_code'=>'+51', 'flag'=>'https://flagcdn.com/pe.svg']);
        Country::create(['name'=>'Philippines', 'code' => 'PH', 'tel_code'=>'+63', 'flag'=>'https://flagcdn.com/ph.svg']);
        Country::create(['name'=>'Pitcairn', 'code' => 'PN', 'tel_code'=>'+64', 'flag'=>'https://flagcdn.com/pn.svg']);
        Country::create(['name'=>'Poland', 'code' => 'PL', 'tel_code'=>'+48', 'flag'=>'https://flagcdn.com/pl.svg']);
        Country::create(['name'=>'Portugal', 'code' => 'PT', 'tel_code'=>'+351', 'flag'=>'https://flagcdn.com/pt.svg']);
        Country::create(['name'=>'Puerto Rico', 'code' => 'PR', 'tel_code'=>'+1787', 'flag'=>'https://flagcdn.com/pr.svg']);

        Country::create(['name'=>'Qatar', 'code' => 'QA', 'tel_code'=>'+974', 'flag'=>'https://flagcdn.com/qa.svg']);

        Country::create(['name'=>'Republic of the Congo', 'code' => 'CG', 'tel_code'=>'+242', 'flag'=>'https://flagcdn.com/cg.svg']);
        Country::create(['name'=>'Reunion', 'code' => 'RE', 'tel_code'=>'+262', 'flag'=>'https://flagcdn.com/re.svg']);
        Country::create(['name'=>'Romania', 'code' => 'RO', 'tel_code'=>'+40', 'flag'=>'https://flagcdn.com/ro.svg']);
        Country::create(['name'=>'Russia', 'code' => 'RU', 'tel_code'=>'+7', 'flag'=>'https://flagcdn.com/ru.svg']);
        Country::create(['name'=>'Rwanda', 'code' => 'RW', 'tel_code'=>'+250', 'flag'=>'https://flagcdn.com/rw.svg']);

        Country::create(['name'=>'Saint Barthelemy', 'code' => 'BL', 'tel_code'=>'+590', 'flag'=>'https://flagcdn.com/bl.svg']);
        Country::create(['name'=>'Saint Helena', 'code' => 'SH', 'tel_code'=>'+290', 'flag'=>'https://flagcdn.com/sh.svg']);
        Country::create(['name'=>'Saint Kitts and Nevis', 'code' => 'KN', 'tel_code'=>'+1869', 'flag'=>'https://flagcdn.com/kn.svg']);
        Country::create(['name'=>'Saint Lucia', 'code' => 'LC', 'tel_code'=>'+1758', 'flag'=>'https://flagcdn.com/lc.svg']);
        Country::create(['name'=>'Saint Martin', 'code' => 'MF', 'tel_code'=>'+590', 'flag'=>'https://flagcdn.com/mf.svg']);
        Country::create(['name'=>'Saint Pierre and Miquelon', 'code' => 'PM', 'tel_code'=>'+508', 'flag'=>'https://flagcdn.com/pm.svg']);
        Country::create(['name'=>'Saint Vincent and the Grenadines', 'code' => 'VC', 'tel_code'=>'+1784', 'flag'=>'https://flagcdn.com/vc.svg']);
        Country::create(['name'=>'Samoa', 'code' => 'WS', 'tel_code'=>'+685', 'flag'=>'https://flagcdn.com/ws.svg']);
        Country::create(['name'=>'San Marino', 'code' => 'SM', 'tel_code'=>'+378', 'flag'=>'https://flagcdn.com/sm.svg']);
        Country::create(['name'=>'Sao Tome and Principe', 'code' => 'ST', 'tel_code'=>'+239', 'flag'=>'https://flagcdn.com/st.svg']);
        Country::create(['name'=>'Saudi Arabia', 'code' => 'SA', 'tel_code'=>'+966', 'flag'=>'https://flagcdn.com/sa.svg']);
        Country::create(['name'=>'Senegal', 'code' => 'SN', 'tel_code'=>'+221', 'flag'=>'https://flagcdn.com/sn.svg']);
        Country::create(['name'=>'Serbia', 'code' => 'RS', 'tel_code'=>'+381', 'flag'=>'https://flagcdn.com/rs.svg']);
        Country::create(['name'=>'Seychelles', 'code' => 'SC', 'tel_code'=>'+248', 'flag'=>'https://flagcdn.com/sc.svg']);
        Country::create(['name'=>'Sierra Leone', 'code' => 'SL', 'tel_code'=>'+232', 'flag'=>'https://flagcdn.com/sl.svg']);
        Country::create(['name'=>'Singapore', 'code' => 'SG', 'tel_code'=>'+65', 'flag'=>'https://flagcdn.com/sg.svg']);
        Country::create(['name'=>'Sint Maarten', 'code' => 'SX', 'tel_code'=>'+1721', 'flag'=>'https://flagcdn.com/sx.svg']);
        Country::create(['name'=>'Slovakia', 'code' => 'SK', 'tel_code'=>'+421', 'flag'=>'https://flagcdn.com/sk.svg']);
        Country::create(['name'=>'Slovenia', 'code' => 'SI', 'tel_code'=>'+386', 'flag'=>'https://flagcdn.com/si.svg']);
        Country::create(['name'=>'Solomon Islands', 'code' => 'SB', 'tel_code'=>'+677', 'flag'=>'https://flagcdn.com/sb.svg']);
        Country::create(['name'=>'Somalia', 'code' => 'SO', 'tel_code'=>'+252', 'flag'=>'https://flagcdn.com/so.svg']);
        Country::create(['name'=>'South Africa', 'code' => 'ZA', 'tel_code'=>'+27', 'flag'=>'https://flagcdn.com/za.svg']);
        Country::create(['name'=>'South Korea', 'code' => 'KR', 'tel_code'=>'+82', 'flag'=>'https://flagcdn.com/kr.svg']);
        Country::create(['name'=>'South Sudan', 'code' => 'SS', 'tel_code'=>'+211', 'flag'=>'https://flagcdn.com/ss.svg']);
        Country::create(['name'=>'Spain', 'code' => 'ES', 'tel_code'=>'+34', 'flag'=>'https://flagcdn.com/es.svg']);
        Country::create(['name'=>'Sri Lanka', 'code' => 'LK', 'tel_code'=>'+94', 'timezone'=>'Asia/Colombo', 'flag'=>'https://flagcdn.com/lk.svg']);
        Country::create(['name'=>'Sudan', 'code' => 'SD', 'tel_code'=>'+249', 'flag'=>'https://flagcdn.com/sd.svg']);
        Country::create(['name'=>'Suriname', 'code' => 'SR', 'tel_code'=>'+597', 'flag'=>'https://flagcdn.com/sr.svg']);
        Country::create(['name'=>'Svalbard and Jan Mayen', 'code' => 'SJ', 'tel_code'=>'+47', 'flag'=>'https://flagcdn.com/sj.svg']);
        Country::create(['name'=>'Swaziland', 'code' => 'SZ', 'tel_code'=>'+268', 'flag'=>'https://flagcdn.com/sz.svg']);
        Country::create(['name'=>'Sweden', 'code' => 'SE', 'tel_code'=>'+46', 'flag'=>'https://flagcdn.com/se.svg']);
        Country::create(['name'=>'Switzerland', 'code' => 'CH', 'tel_code'=>'+41', 'flag'=>'https://flagcdn.com/ch.svg']);
        Country::create(['name'=>'Syria', 'code' => 'SY', 'tel_code'=>'+963', 'flag'=>'https://flagcdn.com/sy.svg']);

        Country::create(['name'=>'Taiwan', 'code' => 'TW', 'tel_code'=>'+886', 'flag'=>'https://flagcdn.com/tw.svg']);
        Country::create(['name'=>'Tajikistan', 'code' => 'TJ', 'tel_code'=>'+992', 'flag'=>'https://flagcdn.com/tj.svg']);
        Country::create(['name'=>'Tanzania', 'code' => 'TZ', 'tel_code'=>'+255', 'flag'=>'https://flagcdn.com/tz.svg']);
        Country::create(['name'=>'Thailand', 'code' => 'TH', 'tel_code'=>'+66', 'flag'=>'https://flagcdn.com/th.svg']);
        Country::create(['name'=>'Togo', 'code' => 'TG', 'tel_code'=>'+228', 'flag'=>'https://flagcdn.com/tg.svg']);
        Country::create(['name'=>'Tokelau', 'code' => 'TK', 'tel_code'=>'+690', 'flag'=>'https://flagcdn.com/tk.svg']);
        Country::create(['name'=>'Tonga', 'code' => 'TO', 'tel_code'=>'+676', 'flag'=>'https://flagcdn.com/to.svg']);
        Country::create(['name'=>'Trinidad and Tobago', 'code' => 'TT', 'tel_code'=>'+1868', 'flag'=>'https://flagcdn.com/tt.svg']);
        Country::create(['name'=>'Tunisia', 'code' => 'TN', 'tel_code'=>'+216', 'flag'=>'https://flagcdn.com/tn.svg']);
        Country::create(['name'=>'Turkey', 'code' => 'TR', 'tel_code'=>'+90', 'flag'=>'https://flagcdn.com/tr.svg']);
        Country::create(['name'=>'Turkmenistan', 'code' => 'TM', 'tel_code'=>'+993', 'flag'=>'https://flagcdn.com/tm.svg']);
        Country::create(['name'=>'Turks and Caicos Islands', 'code' => 'TC', 'tel_code'=>'+1649', 'flag'=>'https://flagcdn.com/tc.svg']);
        Country::create(['name'=>'Tuvalu', 'code' => 'TV', 'tel_code'=>'+688', 'flag'=>'https://flagcdn.com/tv.svg']);

        Country::create(['name'=>'U.S. Virgin Islands', 'code' => 'VI', 'tel_code'=>'+1340', 'flag'=>'https://flagcdn.com/vi.svg']);
        Country::create(['name'=>'Uganda', 'code' => 'UG', 'tel_code'=>'+256', 'flag'=>'https://flagcdn.com/ug.svg']);
        Country::create(['name'=>'Ukraine', 'code' => 'UA', 'tel_code'=>'+380', 'flag'=>'https://flagcdn.com/ua.svg']);
        Country::create(['name'=>'United Arab Emirates', 'code' => 'AE', 'tel_code'=>'+971', 'flag'=>'https://flagcdn.com/ae.svg']);
        Country::create(['name'=>'United Kingdom', 'code' => 'GB', 'tel_code'=>'+44', 'timezone'=>'Europe/London', 'flag'=>'https://flagcdn.com/gb.svg']);
        Country::create(['name'=>'United States', 'code' => 'US', 'tel_code'=>'+1', 'timezone'=>'America/New_York', 'flag'=>'https://flagcdn.com/us.svg']);
        Country::create(['name'=>'Uruguay', 'code' => 'UY', 'tel_code'=>'+598', 'flag'=>'https://flagcdn.com/uy.svg']);
        Country::create(['name'=>'Uzbekistan', 'code' => 'UZ', 'tel_code'=>'+998', 'flag'=>'https://flagcdn.com/uz.svg']);

        Country::create(['name'=>'Vanuatu', 'code' => 'VU', 'tel_code'=>'+678', 'flag'=>'https://flagcdn.com/vu.svg']);
        Country::create(['name'=>'Vatican', 'code' => 'VA', 'tel_code'=>'+379', 'flag'=>'https://flagcdn.com/va.svg']);
        Country::create(['name'=>'Venezuela', 'code' => 'VE', 'tel_code'=>'+58', 'flag'=>'https://flagcdn.com/ve.svg']);
        Country::create(['name'=>'Vietnam', 'code' => 'VN', 'tel_code'=>'+84', 'flag'=>'https://flagcdn.com/vn.svg']);

        Country::create(['name'=>'Wallis and Futuna', 'code' => 'WF', 'tel_code'=>'+681', 'flag'=>'https://flagcdn.com/wf.svg']);
        Country::create(['name'=>'Western Sahara', 'code' => 'EH', 'tel_code'=>'+212', 'flag'=>'https://flagcdn.com/eh.svg']);

        Country::create(['name'=>'Yemen', 'code' => 'YE', 'tel_code'=>'+967', 'flag'=>'https://flagcdn.com/ye.svg']);

        Country::create(['name'=>'Zambia', 'code' => 'ZM', 'tel_code'=>'+260', 'flag'=>'https://flagcdn.com/zm.svg']);
        Country::create(['name'=>'Zimbabwe', 'code' => 'ZW', 'tel_code'=>'+263', 'flag'=>'https://flagcdn.com/zw.svg']);
    }
}
