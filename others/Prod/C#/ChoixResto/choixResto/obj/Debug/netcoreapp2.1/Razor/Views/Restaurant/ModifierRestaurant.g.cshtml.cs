#pragma checksum "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Restaurant/ModifierRestaurant.cshtml" "{ff1816ec-aa5e-4d10-87f7-6f4963833460}" "c79c9fffc6537b418e4bd531b1aa625613b55b5b"
// <auto-generated/>
#pragma warning disable 1591
[assembly: global::Microsoft.AspNetCore.Razor.Hosting.RazorCompiledItemAttribute(typeof(AspNetCore.Views_Restaurant_ModifierRestaurant), @"mvc.1.0.view", @"/Views/Restaurant/ModifierRestaurant.cshtml")]
[assembly:global::Microsoft.AspNetCore.Mvc.Razor.Compilation.RazorViewAttribute(@"/Views/Restaurant/ModifierRestaurant.cshtml", typeof(AspNetCore.Views_Restaurant_ModifierRestaurant))]
namespace AspNetCore
{
    #line hidden
    using System;
    using System.Collections.Generic;
    using System.Linq;
    using System.Threading.Tasks;
    using Microsoft.AspNetCore.Mvc;
    using Microsoft.AspNetCore.Mvc.Rendering;
    using Microsoft.AspNetCore.Mvc.ViewFeatures;
#line 1 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/_ViewImports.cshtml"
using choixResto;

#line default
#line hidden
#line 2 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/_ViewImports.cshtml"
using choixResto.Models;

#line default
#line hidden
    [global::Microsoft.AspNetCore.Razor.Hosting.RazorSourceChecksumAttribute(@"SHA1", @"c79c9fffc6537b418e4bd531b1aa625613b55b5b", @"/Views/Restaurant/ModifierRestaurant.cshtml")]
    [global::Microsoft.AspNetCore.Razor.Hosting.RazorSourceChecksumAttribute(@"SHA1", @"53ec775c959a7eaf7b003b77fcd61d568d92ce47", @"/Views/_ViewImports.cshtml")]
    public class Views_Restaurant_ModifierRestaurant : global::Microsoft.AspNetCore.Mvc.Razor.RazorPage<ChoixResto.Models.Resto>
    {
        #pragma warning disable 1998
        public async override global::System.Threading.Tasks.Task ExecuteAsync()
        {
            BeginContext(32, 2, true);
            WriteLiteral("\r\n");
            EndContext();
#line 3 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Restaurant/ModifierRestaurant.cshtml"
 using (Html.BeginForm())
{

#line default
#line hidden
            BeginContext(64, 92, true);
            WriteLiteral("    <fieldset>\r\n        <legend>Modifier un restaurant</legend>\r\n        <div>\r\n            ");
            EndContext();
            BeginContext(157, 33, false);
#line 8 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Restaurant/ModifierRestaurant.cshtml"
       Write(Html.LabelFor(model => model.Nom));

#line default
#line hidden
            EndContext();
            BeginContext(190, 14, true);
            WriteLiteral("\r\n            ");
            EndContext();
            BeginContext(205, 35, false);
#line 9 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Restaurant/ModifierRestaurant.cshtml"
       Write(Html.TextBoxFor(model => model.Nom));

#line default
#line hidden
            EndContext();
            BeginContext(240, 45, true);
            WriteLiteral("\r\n        </div>\r\n        <div>\r\n            ");
            EndContext();
            BeginContext(286, 39, false);
#line 12 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Restaurant/ModifierRestaurant.cshtml"
       Write(Html.LabelFor(model => model.Telephone));

#line default
#line hidden
            EndContext();
            BeginContext(325, 14, true);
            WriteLiteral("\r\n            ");
            EndContext();
            BeginContext(340, 41, false);
#line 13 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Restaurant/ModifierRestaurant.cshtml"
       Write(Html.TextBoxFor(model => model.Telephone));

#line default
#line hidden
            EndContext();
            BeginContext(381, 101, true);
            WriteLiteral("\r\n        </div>\r\n        <br />\r\n        <input type=\"submit\" value=\"Modifier\" />\r\n    </fieldset>\r\n");
            EndContext();
#line 18 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Restaurant/ModifierRestaurant.cshtml"
}

#line default
#line hidden
        }
        #pragma warning restore 1998
        [global::Microsoft.AspNetCore.Mvc.Razor.Internal.RazorInjectAttribute]
        public global::Microsoft.AspNetCore.Mvc.ViewFeatures.IModelExpressionProvider ModelExpressionProvider { get; private set; }
        [global::Microsoft.AspNetCore.Mvc.Razor.Internal.RazorInjectAttribute]
        public global::Microsoft.AspNetCore.Mvc.IUrlHelper Url { get; private set; }
        [global::Microsoft.AspNetCore.Mvc.Razor.Internal.RazorInjectAttribute]
        public global::Microsoft.AspNetCore.Mvc.IViewComponentHelper Component { get; private set; }
        [global::Microsoft.AspNetCore.Mvc.Razor.Internal.RazorInjectAttribute]
        public global::Microsoft.AspNetCore.Mvc.Rendering.IJsonHelper Json { get; private set; }
        [global::Microsoft.AspNetCore.Mvc.Razor.Internal.RazorInjectAttribute]
        public global::Microsoft.AspNetCore.Mvc.Rendering.IHtmlHelper<ChoixResto.Models.Resto> Html { get; private set; }
    }
}
#pragma warning restore 1591