class Major:

    def __init__(self):
        # self.name = name
        self.requirements = {}

    def get_requirements(self, year_group, level, semester):
        if semester == 1:
            return self.requirements[year_group][(level*2)-1]
        elif semester == 2:
            return self.requirements[year_group][(level*2)]

class CS(Major):
    def __init__(self):
        super().__init__()
        self.requirements.update({2024: {1: 4.5, 2: 9, 3: 13.5, 4: 17.5, 5: 22, 6: 26, 7: 30, 8: 34},
                                2025: {1: 4, 2: 8.5, 3: 13, 4: 17.5, 5: 22.5, 6: 27.5, 7: 31.5, 8: 35.5},}
                                #2026: {1: 18, 2: 36, 3: 54, 4: 72, 5: 70, 6: 90, 7: 100, 8: 120}}
    )
    
class BA(Major):
    def __init__(self):
        super().__init__()
        self.requirements.update({2024: {1: 4.5, 2: 9, 3: 13.5, 4: 17.5, 5: 21.5, 6: 25.5, 7: 29.5, 8: 33.5},
                                2025: {1: 4.5, 2: 9, 3: 13.5, 4: 17.5, 5: 21.5, 6: 25.5, 7: 29.5, 8: 33.5},})
                    # 2026: {1: 18, 2: 36, 3: 54, 4: 72, 5: 70, 6: 90, 7: 100, 8: 120}}

class MIS(Major):
    def __init__(self):
        super().__init__()
        self.requirements.update({2024: {1: 4.5, 2: 9, 3: 13.5, 4: 17.5, 5: 21.5, 6: 25, 7: 29, 8: 33},
                    2025: {1: 5, 2: 9.5, 3: 14, 4: 18.5, 5: 22, 6: 25.5, 7: 29.5, 8: 33.5},})
                    # 2026: {1: 18, 2: 36, 3: 54, 4: 72, 5: 70, 6: 90, 7: 100, 8: 120}}

class EE(Major):
    def __init__(self):
        super().__init__()
        self.requirements.update({2024: {1: 4.5, 2: 9, 3: 13.5, 4: 17.5, 5: 21.5, 6: 25, 7: 29, 8: 33},
                    2025: {1: 5, 2: 9.5, 3: 14, 4: 18.5, 5: 22, 6: 25.5, 7: 29.5, 8: 33.5},})
                    # 2026: {1: 18, 2: 36, 3: 54, 4: 72, 5: 70, 6: 90, 7: 100, 8: 120}}

class ME(Major):
    def __init__(self):
        super().__init__()
        self.requirements.update({2024: {1: 4.5, 2: 9, 3: 13.5, 4: 17.5, 5: 21.5, 6: 25, 7: 29, 8: 33},
                    2025: {1: 5, 2: 9.5, 3: 14, 4: 18.5, 5: 22, 6: 25.5, 7: 29.5, 8: 33.5},})
                    # 2026: {1: 18, 2: 36, 3: 54, 4: 72, 5: 70, 6: 90, 7: 100, 8: 120}}
    
class CE(Major):
    def __init__(self):
        super().__init__()
        self.requirements.update({2024: {1: 4.5, 2: 9, 3: 13.5, 4: 17.5, 5: 21.5, 6: 25, 7: 29, 8: 33},
                    2025: {1: 5, 2: 9.5, 3: 14, 4: 18.5, 5: 22, 6: 25.5, 7: 29.5, 8: 33.5},})
                    # 2026: {1: 18, 2: 36, 3: 54, 4: 72, 5: 70, 6: 90, 7: 100, 8: 120}}
