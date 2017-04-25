<?php

namespace Encore\Admin\Form\Field;

class DateTimePersian extends DatePersian
{
    protected $options = '{
        format: "YYYY-MM-DD HH:mm",
        timePicker: {
            enabled: true,
            showSeconds: false,
        },
        formatter: function(t) {
            var t = new Date(t);
            var y = t.getFullYear();
            var M = t.getMonth()+1;
            M = M >= 10 ? M : "0"+M;
            var d = t.getDate();
            d = d >= 10 ? d : "0"+d;
            var h = t.getHours();
            h = h >= 10 ? h : "0"+h;
            var m = t.getMinutes();
            m = m >= 10 ? m : "0"+m;
            return y+"-"+M+"-"+d+" "+h+":"+m;
        }
    }';
}
