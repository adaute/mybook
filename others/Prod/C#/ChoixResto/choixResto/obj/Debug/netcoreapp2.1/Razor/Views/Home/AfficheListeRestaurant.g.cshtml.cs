#pragma checksum "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Home/AfficheListeRestaurant.cshtml" "{ff1816ec-aa5e-4d10-87f7-6f4963833460}" "190854ee776edcf50114ac23d15595593da24656"
// <auto-generated/>
#pragma warning disable 1591
[assembly: global::Microsoft.AspNetCore.Razor.Hosting.RazorCompiledItemAttribute(typeof(AspNetCore.Views_Home_AfficheListeRestaurant), @"mvc.1.0.view", @"/Views/Home/AfficheListeRestaurant.cshtml")]
[assembly:global::Microsoft.AspNetCore.Mvc.Razor.Compilation.RazorViewAttribute(@"/Views/Home/AfficheListeRestaurant.cshtml", typeof(AspNetCore.Views_Home_AfficheListeRestaurant))]
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
    [global::Microsoft.AspNetCore.Razor.Hosting.RazorSourceChecksumAttribute(@"SHA1", @"190854ee776edcf50114ac23d15595593da24656", @"/Views/Home/AfficheListeRestaurant.cshtml")]
    [global::Microsoft.AspNetCore.Razor.Hosting.RazorSourceChecksumAttribute(@"SHA1", @"53ec775c959a7eaf7b003b77fcd61d568d92ce47", @"/Views/_ViewImports.cshtml")]
    public class Views_Home_AfficheListeRestaurant : global::Microsoft.AspNetCore.Mvc.Razor.RazorPage<List<ChoixResto.Models.Resto>>
    {
        #pragma warning disable 1998
        public async override global::System.Threading.Tasks.Task ExecuteAsync()
        {
            BeginContext(38, 80, true);
            WriteLiteral("<table>\r\n    <tr>\r\n        <th>Nom</th>\r\n        <th>Téléphone</th>\r\n    </tr>\r\n");
            EndContext();
#line 7 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Home/AfficheListeRestaurant.cshtml"
     foreach (var resto in Model)
    {

#line default
#line hidden
            BeginContext(160, 30, true);
            WriteLiteral("        <tr>\r\n            <td>");
            EndContext();
            BeginContext(191, 9, false);
#line 10 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Home/AfficheListeRestaurant.cshtml"
           Write(resto.Nom);

#line default
#line hidden
            EndContext();
            BeginContext(200, 23, true);
            WriteLiteral("</td>\r\n            <td>");
            EndContext();
            BeginContext(224, 15, false);
#line 11 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Home/AfficheListeRestaurant.cshtml"
           Write(resto.Telephone);

#line default
#line hidden
            EndContext();
            BeginContext(239, 22, true);
            WriteLiteral("</td>\r\n        </tr>\r\n");
            EndContext();
#line 13 "/Users/adrienagnel/Projects/choixResto/choixResto/Views/Home/AfficheListeRestaurant.cshtml"
    }

#line default
#line hidden
            BeginContext(268, 8, true);
            WriteLiteral("</table>");
            EndContext();
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
        public global::Microsoft.AspNetCore.Mvc.Rendering.IHtmlHelper<List<ChoixResto.Models.Resto>> Html { get; private set; }
    }
}
#pragma warning restore 1591
