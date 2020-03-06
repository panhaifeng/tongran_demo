!function($){
 /* 基于Bootstrap Typeahead改造而来的自动完成插件
  * Author：F.L.F
  * Site: http://digdata.me
  * ================================= */

  var Autocomplete = function (element, options) {
    this.$element = $(element)
    this.options = $.extend({}, $.fn.autocomplete.defaults, options)
    this.sorter = this.options.sorter || this.sorter
    this.highlighter = this.options.highlighter || this.highlighter
    this.updater = this.options.updater || this.updater
    this.source = this.options.source
    this.$menu = $(this.options.menu)
    this.shown = false
  	this.formatItem = this.options.formatItem || this.formatItem
  	this.setValue = this.options.setValue || this.setValue
    this.listen()
    this.init();
    //显示选项时触发
    this.onClickShowall = this.options.onClickShowall || this.onClickShowall;
    //控件获得焦点时是否显示所有options
    //this.showallOnfocus = this.options.showallOnfocus || false;
    //阻止keyup事件触发,防止item被选中,一般在回车切换焦点时需要用到
    this._preventSelect = false;
    //2014-9-5 by jeff,增加一个容器，当source为function时，这个容器包含了所有的选项，方便showAllItem调用
    // this.cacheItem = options.cacheItem;
  }

  Autocomplete.prototype = {
    constructor: Autocomplete
  // ad by jeff 2014-9-1 ,在自动完成控件后增加一个下拉按钮,点击下拉按钮触发提示框的弹出
  // 还是有个bug,在显示提示项没有选定的状态下，点击按钮，会导致无法选择
  //最好改为显示弹出选择，支持上下，回车选中
  , init :function () {
    var element = this.$element;
    var $this = this;
    //找到后面的按钮，定义事件,这里不好封装，主要是因为闭包，导致外面的变量无法通过引用改变属性
    //会有比较大的代码调整，还不如直接在外面写个事件
    $('#btnShowAuto',element.parent()).click(function(e){
      console.log('btn clicked, show items,this.shown is '+$this.shown)
      e.stopPropagation()
      e.preventDefault()
      var items = $this.onClickShowall();
      $this.showAllItem(items);
      element.focus();
    });
  }
  , processObj:0
  //阻止keyup事件被触发
  ,preventSelect:function(b) {
    this._preventSelect = b;
  }
  , formatItem:function(item){
    // return 'aaa';
		return item.toString();
	}
  , setValue:function(item){
		return {"data-value":item.toString(),"real-value":item.toString()};
    }
  
  , select: function () {
    var val = this.$menu.find('.active').attr('data-value')
	  var realVal = this.$menu.find('.active').attr('real-value')
      this.$element
        .val(this.updater(val)).attr("real-value",realVal)
        .change()
      return this.hide()
    }

  , updater: function (item) {
      return item;
    }

  , show: function () {
      var pos = $.extend({}, this.$element.position(), {
        height: this.$element[0].offsetHeight
      })

      this.$menu
        .insertAfter(this.$element)
        .css({
          top: pos.top + pos.height
        , left: pos.left
        })
        .show()

      this.shown = true

      //2014-8-12 by jeff,增加一个控件的状态属性，在跳转焦点时需要使用到
      this.$element.attr('showOptions',1);
      return this
    }

  , hide: function () {
      this.$menu.hide()
      this.shown = false
      //2014-8-12 by jeff,增加一个控件的状态属性，在跳转焦点时需要使用到
      this.$element.attr('showOptions',0);
      return this
    }

  , lookup: function (event) {
      var items
      this.query = this.$element.val()
      if (!this.query || this.query.length < this.options.minLength) {
        return this.shown ? this.hide() : this
      }
      items = $.isFunction(this.source) ? this.source(this.query, $.proxy(this.process, this)) : this.source
      return items ? this.process(items) : this
    }
  , showAllItem : function(items) {
    //2014-9-5 by jeff,强制显示所有的选项
    //如果正在显示，先隐藏掉
    if(this.shown) {
      this.hide();
    }
    this.query = this.$element.val();
    if(this.query=='') {
      return items&&items.length>0 ? this.process(items) : this;
    }
    return this.lookup();
  }
  , process: function (items) {
      var that = this
      if (!items.length) {
        return this.shown ? this.hide() : this
      }

      return this.render(items.slice(0, this.options.items)).show()
    }
 
  , highlighter: function (item) {
	  var that = this
	  item = that.formatItem(item)
      var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
      return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
        return '<strong style="color:#FF6600;">' + match + '</strong>'
      })
    }

  , render: function (items) {
      var that = this

      items = $(items).map(function (i, item) {
        i = $(that.options.item).attr(that.setValue(item))
        i.find('a').html(that.highlighter(item))
        return i[0]
      })

      items.first().addClass('active')
      this.$menu.html(items)
      return this
    }

  , next: function (event) {
      var active = this.$menu.find('.active').removeClass('active')
        , next = active.next()

      if (!next.length) {
        next = $(this.$menu.find('li')[0])
      }

      next.addClass('active')
    }

  , prev: function (event) {
      var active = this.$menu.find('.active').removeClass('active')
        , prev = active.prev()

      if (!prev.length) {
        prev = this.$menu.find('li').last()
      }

      prev.addClass('active')
    }

  , listen: function () {
      this.$element
        .on('focus',    $.proxy(this.focus, this))
        .on('blur',     $.proxy(this.blur, this))
        .on('keypress', $.proxy(this.keypress, this))
        .on('keyup',    $.proxy(this.keyup, this))

      if (this.eventSupported('keydown')) {
        this.$element.on('keydown', $.proxy(this.keydown, this))
      }

      this.$menu
        .on('click', $.proxy(this.click, this))
        .on('mouseenter', 'li', $.proxy(this.mouseenter, this))
        .on('mouseleave', 'li', $.proxy(this.mouseleave, this))
    }

  , eventSupported: function(eventName) {
      var isSupported = eventName in this.$element
      if (!isSupported) {
        this.$element.setAttribute(eventName, 'return;')
        isSupported = typeof this.$element[eventName] === 'function'
      }
      return isSupported
    }

  , move: function (e) {
      if (!this.shown) return

      switch(e.keyCode) {
        case 9: // tab
        case 13: // enter
        case 27: // escape
          e.preventDefault()
          break

        case 38: // up arrow
          e.preventDefault()
          this.prev()
          break

        case 40: // down arrow
          e.preventDefault()
          this.next()
          break
      }

      e.stopPropagation()
    }

  , keydown: function (e) {
      this.suppressKeyPressRepeat = ~$.inArray(e.keyCode, [40,38,9,13,27])
      this.move(e)
    }

  , keypress: function (e) {
	  
      if (this.suppressKeyPressRepeat) return
      this.move(e)
    }

  , keyup: function (e) {
      switch(e.keyCode) {
        case 40: // down arrow
        case 38: // up arrow
        case 16: // shift
        case 17: // ctrl
        case 18: // alt
          break

        case 9: // tab
        case 13: // enter
          // console.log('keyup:this.show is '+this.shown);
          console.log('_preventSelect '+this._preventSelect)
          if (!this.shown) return
          //回车切换焦点时，需要设置_preventSelect为true，否则会意外触发
          if(!this._preventSelect) {
            this.select();
            
          } else this._preventSelect = false;
          break

        case 27: // escape
          if (!this.shown) return
          this.hide()
          break

        default:
		  var that = this
		  if(that.processObj){
		    clearTimeout(that.processObj)
			  that.processObj = 0
		  }
		  that.processObj = setTimeout(function(){
			that.lookup()
		  },that.options.delay)
      }

      e.stopPropagation()
      e.preventDefault()
    }

  , focus: function (e) {
      this.focused = true
    }

  , blur: function (e) {
      // console.log('blur');
      this.focused = false
      if (!this.mousedover && this.shown) this.hide()
    }

  , click: function (e) {
      e.stopPropagation()
      e.preventDefault()
      this.select()
      this.$element.focus()
    }

  , mouseenter: function (e) {
      this.mousedover = true
      this.$menu.find('.active').removeClass('active')
      $(e.currentTarget).addClass('active')
    }

  , mouseleave: function (e) {
      this.mousedover = false
      if (!this.focused && this.shown) this.hide()
    }

  }


  /* TYPEAHEAD PLUGIN DEFINITION
   * =========================== */

  var old = $.fn.autocomplete
  //2014-9-5 by jeff,增加了_relatedTarget参数，暴露一些需要参数的方法
  $.fn.autocomplete = function (option,_relatedTarget) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('autocomplete')
        , options = typeof option == 'object' && option
      if (!data) $this.data('autocomplete', (data = new Autocomplete(this, options)))
      if (typeof option == 'string') {
        //得到后面的参数
        data[option](_relatedTarget);
      }
      //2014-8-12 by jeff,标记是否自动完成控件
      $this.attr('isAutoComplete',1);
    })
  }

  $.fn.autocomplete.defaults = {
    source: []
  , items: 8
  , menu: '<ul class="typeahead dropdown-menu"></ul>'
  , item: '<li><a href="#"></a></li>'
  , minLength: 1
  , delay: 500
  //2014-9-5 by jeff,增加一个onClickShowall事件,用于当客户点击右边的showAll按钮时触发
  ,onClickShowall:function(items) {
      console.log(items);
      // alert(1);
    }
  }

  $.fn.autocomplete.Constructor = Autocomplete


 /* TYPEAHEAD NO CONFLICT
  * =================== */

  $.fn.autocomplete.noConflict = function () {
    $.fn.autocomplete = old
    return this
  }


 /* TYPEAHEAD DATA-API
  * ================== */

  $(document).on('focus.autocomplete.data-api', '[data-provide="autocomplete"]', function (e) {
    var $this = $(this)
    if ($this.data('autocomplete')) return
    $this.autocomplete($this.data())
  })

}(window.jQuery);