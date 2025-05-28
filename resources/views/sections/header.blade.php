<header class="head02">

    <div class="top">
      <div class="offer_top">
        <div class="container">
          <div class="row">
            <div class="offer_top_wrapper">
        <span class="">Ειδική Πρoσφορά -10%</span>
            </div>
        
          </div>
        </div>
      
      </div>
        <div class="top_wrapper">
        @if (has_nav_menu('info_navigation'))
          <nav class="nav-info" aria-label="{{ wp_get_nav_menu_name('info_navigation') }}">
            {!! wp_nav_menu(['theme_location' => 'info_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
          </nav>
        @endif
       
        <div class="logosearch">
          <div class="searchrow">
            <div class="searchwrap">
          @if ( function_exists( 'the_custom_logo' ) ) 
  	       @php echo (the_custom_logo()); @endphp 
          @endif
            <div class="searchbar"> 
        
              @php echo facetwp_display( 'facet', 'search' ); @endphp
         
              <div class="selections">
              @php echo facetwp_display( 'selections' ); @endphp
              </div>    
            
            </div>

                  </div>
                </div>         
        </div>

        @if (has_nav_menu('info_navigation'))
          <nav class="nav-help" aria-label="{{ wp_get_nav_menu_name('help_navigation') }}">
            {!! wp_nav_menu(['theme_location' => 'help_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
          </nav>
        @endif

        </div>
    
    </div>
  <div class="head_mobile">
              <div class="searchbarscroll"> 

              <div class="col-1">
                col-3
              </div>
              <div class="col-9">
               @php echo facetwp_display( 'facet', 'search' ); @endphp
              </div>
              <div class="col-2">
                col-3
              </div>        
              <div class="selections">
                <div class="row">
                  <div class="col-1">
                 
                  </div>
                  @php echo facetwp_display( 'selections' ); @endphp
                  <div class="col-1">
           
                  </div>
                
                </div>  
              </div>    
            
            </div>

</div>
  </header>

