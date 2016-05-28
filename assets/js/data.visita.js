jQuery(function($) {

    acf.fields.date_picker_visita = {
        $el : null,
        $input : null,
        $hidden : null,
        o : {},
        set : function( o ){
            $.extend( this, o );
            this.$input = this.$el.find('input[type="text"]');
            this.$hidden = this.$el.find('input[type="hidden"]');
            this.o = acf.helpers.get_atts( this.$el );
            return this;
        },
        init : function(){
            if( acf.helpers.is_clone_field(this.$hidden) ) {
                return;
            }
            this.$input.val( this.$hidden.val() );
            var options = $.extend( {}, acf.l10n.date_picker_visita, { 
                dateFormat      :   this.o.save_format,
                altField        :   this.$hidden,
                altFormat       :   this.o.save_format,
                changeYear      :   true,
                yearRange       :   "-100:+100",
                changeMonth     :   true,
                showButtonPanel :   true,
                closeText: "Fechar",
                prevText: "&#x3C;Anterior",
                nextText: "Próximo&#x3E;",
                currentText: "Hoje",
                dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
                dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                weekHeader: "Sm",
                firstDay        :   this.o.first_day,
                onSelect: function(dateText, instance) {
                    date = $.datepicker.parseDate(instance.settings.dateFormat, dateText, instance.settings);
                    date.setMonth(date.getMonth() + 1);
                    $(".field_key-field_57338b71d62d6 .input").datepicker("setDate", date);
                }
            });
            this.$input.addClass('active').datepicker( options );
            this.$input.datepicker( "option", "dateFormat", this.o.display_format );
            if( $('body > #ui-datepicker-div').length > 0 ) {
                $('#ui-datepicker-div').wrap('<div class="ui-acf" />');
            }
        },
        blur : function(){
            if( !this.$input.val() ) {
                this.$hidden.val('');
            }
        }
    };
    
    $(document).on('acf/setup_fields', function(e, el){
        $(el).find('.acf-date_picker_visita').each(function(){
            acf.fields.date_picker_visita.set({ $el : $(this) }).init();
        });
    });
    
    $(document).on('blur', '.acf-date_picker_visita input[type="text"]', function( e ){
        acf.fields.date_picker_visita.set({ $el : $(this).parent() }).blur();
    });

    $('.field_key-field_57338b57d62d5').find('div').removeClass('acf-date_picker').addClass('acf-date_picker_visita');

})(jQuery);