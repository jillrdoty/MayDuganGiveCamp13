using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace UnitConverter_Lab_
{
    public class DistanceConverter : IUnitConverter 
    {
        public string FromUnit { get; set; }
        public string ToUnit { get; set; }

        public DistanceConverter(string fromUnit, string toUnit)
        {
            FromUnit = fromUnit;
            ToUnit = toUnit;
        }

        public decimal Convert(decimal input)
        {
            if (FromUnit == "KM" && ToUnit == "MI")
                return input * 0.62137M;

            if (FromUnit == "MI" && ToUnit == "KM")
                return input*1.60934M;
            
            return 0;
            // ...
        }
    }
}
